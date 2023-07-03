<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiBaseController as ApiBaseController;
use App\Http\Controllers\Controller;
use App\Models\Intrest;
use Illuminate\Http\Request;
use App\Repositories\IntrestRepository;
use Illuminate\Support\Facades\Auth;


class InterestController extends ApiBaseController
{
    protected IntrestRepository $intrestRepository;

    public function __construct(IntrestRepository $intrestRepository)
    {
        $this->IntrestRepository = $intrestRepository;
    }

    public function getInterest(Request $request)
    {
        try {

            $limit = $request->input('limit', 10);
            $page = $request->input('offset', 0);
            $interests = Intrest::where('status',true)->limit($limit)->offset(($page - 1) * $limit)->get();

            $data = [];

            foreach ($interests as $interest) {
                $data[] = [
                    'id' => $interest->id,
                    'icon' => $interest->icon,
                    'name' => $interest->name,
                    'slug' => $interest->slug,
                    'status' => $interest->status,
                    'deleted_at' => $interest->deleted_at,
                ];
            }

            return $this->sendResponse($data, "");
        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during process.', [], 404);

        }

    }
    public function storeInterest(Request $request)
    {
        try {
            $user = Auth::user();

            $interestIds = $request->input('interests', []);
            $user->interests()->sync($interestIds);
            return $this->sendResponse([], "Interest Post succesfully");
        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during process.', [], 404);

        }

    }

}
