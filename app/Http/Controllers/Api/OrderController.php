<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiBaseController as ApiBaseController;
use App\Http\Controllers\Controller;
use App\Models\BookingInformation;
use App\Models\Order;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class OrderController extends ApiBaseController
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->OrderRepository = $orderRepository;
    }

    public function storeOrders(Request $request): JsonResponse
    {
        try {
            $validation = Validator::make($request->all(), Order::$rules, BookingInformation::$rules);

            if ($validation->fails()) {
                return $this->sendError('Validation Error.', $validation->errors());
            }
            $user = Auth::user();
            $randomNumber = random_int(100000, 999999);
            $random12DigitNumber = sprintf("%012d", $randomNumber);

            $order = Order::create([
                'user_id' => $user->id,
                'order_no' => $random12DigitNumber,
                'service_id' => $request->input('service_id'),
                'order_type' => $request->input('order_type'),
                'start_time' => $request->input('start_time'),
                'end_time' => $request->input('end_time'),
                'available' => $request->input('available'),
                'booking' => $request->input('booking'),
                'lat' => $request->input('lat'),
                'lng' => $request->input('lng')
            ]);
            BookingInformation::create([
                'order_id' => $order->id,
                'month' => $request->input('month'),
                'days' => json_encode($request->input('days')),
                'year' => $request->input('year')
            ]);
            return $this->sendResponse('', 'Order Created successfully.');

        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during Creating Orders.', [], 404);
        }
    }

    public function getUserCart(Request $request): JsonResponse
    {
        try {
            $limit = $request->input('limit', 10);
            $page = $request->input('offset', 0);
            $user = Auth::user();
            $data = Order::with('bookingInformation', 'service', 'service.user')->where('user_id', $user->id)->limit($limit)->offset(($page - 1) * $limit)->get();
            $totalOrderAmount = 0; // Initialize the sum

            $orders = Order::with('service')->get();

            foreach ($orders as $order) {
                $servicePrice = $order->service->service_price;
                $totalOrderAmount += (float)$servicePrice;
            }
            $prepareData = [];
            foreach ($data as $items) {

                $prepareData[] = [
                    "id" => $items->id,
                    "user_id" => $items->user_id,
                    "service_id" => $items->service_id,
                    "order_no" => $items->order_no,
                    "order_type" => $items->order_type,
                    "start_time" => $items->start_time,
                    "end_time" => $items->end_time,
                    "available" => $items->available,
                    "booking" => $items->booking,
                    "lat" => $items->lat,
                    "lng" => $items->lng,
                    "bookingInformation" => [
                        "id" => $items->bookingInformation->id,
                        "month" => $items->bookingInformation->month,
                        "days" => $items->bookingInformation->days,
                        "year" => $items->bookingInformation->year,
                    ],
                    "serviceDetails" => [
                        "id" => $items->service->id,
                        'category_id' => $items->service->category_id,
                        'name' => $items->service->name,
                        'gender' => $items->service->gender,
                        'experience' => $items->service->experience,
                        'service_type' => $items->service->service_type,
                        'address' => $items->service->address,
                        'city' => $items->service->city,
                        'service_price' => $items->service->service_price,
                        'user' => $items->service->user->first_name . $items->service->user->last_name,
                    ]
                ];
            }
            // Add the total order amount to the prepared data
            $prepareData['SubTotal'] = $totalOrderAmount;
            return $this->sendResponse($prepareData, '');
        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during processing.', [], 404);
        }
    }

    public function deleteCartItem($id): JsonResponse
    {
        try {

            $orders = Order::where('id', $id)->first();
            $orders->delete();
            $orders->bookingInformation->delete();
            return $this->sendResponse('', 'Item Removed From the Cart SuccessFully !');

        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during processing.', [], 404);
        }
    }

}
