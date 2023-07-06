<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;

class CategoryController extends ApiBaseController
{
    protected CategoryRepository $intrestRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->CategoryRepository = $categoryRepository;
    }

    public function getCategory(Request $request): JsonResponse
    {
        try {

            $limit = $request->input('limit', 10);
            $page = $request->input('offset', 0);
            $categories = Category::where('status',true)->limit($limit)->offset(($page - 1) * $limit)->get();

            $data = [];

            foreach ($categories as $category) {
                $data[] = [
                    'id' => $category->id,
                    'icon' => "CategoryImages/".$category->icon,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'status' => $category->status,
                    'deleted_at' => $category->deleted_at,
                ];
            }

            return $this->sendResponse($data, "");
        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during process.', [], 404);

        }

    }
}
