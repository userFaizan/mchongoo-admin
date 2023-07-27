<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiBaseController as ApiBaseController;
use App\Http\Controllers\Controller;
use App\Models\FavouriteService;
use App\Models\Service;
use App\Models\User;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServiceController extends ApiBaseController
{
    public const ITEM_COUNT = 30;

    protected ServiceRepository $intrestRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->ServiceRepository = $serviceRepository;
    }

    public function getService(Request $request)
    {

        try {
            $limit = $request->input('limit', 10);
            $page = $request->input('offset', 0);
            $queryParam = $request->input('serviceParam');
            if ($queryParam === null) {
                $data = Service::with('user', 'servicesImages', 'plansAndPackages','favouriteServices')->limit($limit)->offset(($page - 1) * $limit)->get();
            }
            elseif ($queryParam === 'Recommended') {
                $data = Service::with('user', 'servicesImages', 'plansAndPackages','favouriteServices')->where('recommended', true)->limit($limit)->offset(($page - 1) * $limit)->get();
            }
            elseif ($queryParam === 'Trending') {
                $data = Service::with('user', 'servicesImages', 'plansAndPackages','favouriteServices')->where('trending', true)->limit($limit)->offset(($page - 1) * $limit)->get();
            }
            elseif ($queryParam === 'MostViewed') {
                $data = Service::with('user', 'servicesImages', 'plansAndPackages','favouriteServices')->orderBy('view_count', 'desc')->limit($limit)->offset(($page - 1) * $limit)->get();
            }
            elseif ($queryParam === "Location"){
                $radius = 200; // Radius in kilometers
                $latitude = $request->input('latitude');
                $longitude = $request->input('longitude');
                $data = Service::withinRadius($latitude, $longitude, $radius)
                    ->with('user', 'servicesImages', 'plansAndPackages','favouriteServices')
                    ->get();
            }
            else {
                $data = Service::with('user', 'servicesImages', 'plansAndPackages','favouriteServices')->where('city', 'LIKE', '%'.$queryParam.'%')->limit($limit)->offset(($page - 1) * $limit)->get();
            }
            return $this->sendResponse($data, "");

        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during process.', [], 404);

        }
    }

    public function searchService(Request $request)
    {
        try {
        $filters= $request->only('name','experience','service_type','city');
        $services = $this->ServiceRepository->findByFilters($filters , [] , [] , new Service())->paginate(self::ITEM_COUNT);
            return $this->sendResponse($services, "");

        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during process.', [], 404);

        }
    }

    public function getSingleService(Request $request, $id)
    {
        try {
            $limit = $request->input('limit', 10);
            $page = $request->input('offset', 0);
            $data = Service::with('user', 'servicesImages', 'plansAndPackages','favouriteServices')->where('id', $id)->limit($limit)->offset(($page - 1) * $limit)->first();
            $data->increment('view_count');
            return $this->sendResponse($data, "");
        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during process.', [], 404);

        }
    }

    public function favouriteService(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), FavouriteService::$rules);

            if ($validation->fails()) {
                return $this->sendError('Validation Error.', $validation->errors());
            }
            $user = Auth::user();
            if ($user) {
                FavouriteService::updateOrCreate([
                    'user_id' => $user->id,
                    'service_id' => $request->service_id,
                    'is_favorite' => $request->is_favorite
                ]);
                return $this->sendResponse([], 'Service Add to Favourite successfully.');

            } else {
                return $this->sendError('User not Found', [], 404);

            }
        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during resendOtp.', [], 404);
        }
    }

    public function getFavouriteService(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $page = $request->input('offset', 0);
            $data = FavouriteService::with('user', 'service')->limit($limit)->offset(($page - 1) * $limit)->get();
            return $this->sendResponse($data, "");

        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during resendOtp.', [], 404);
        }
    }
}
