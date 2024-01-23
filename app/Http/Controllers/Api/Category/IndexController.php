<?php

namespace App\Http\Controllers\Api\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class IndexController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        $desiredLanguage = $request->header('Accept-Language');
        app()->setLocale($desiredLanguage);
        $categories = Category::all();

        $translatedCategories = [];
        foreach ($categories as $category) {
            // Add the translated name to the product data
            $translatedCategories[] = [
                'id' => $category->id,
                'name' => $category->name,
                'image' => asset(Storage::url('images/' . $category->image)),
                'created_at' => $category->created_at->format('d/m/Y'),
                'updated_at' => $category->updated_at->format('d/m/Y'),
            ];
        }
        return $this->sendResponse($translatedCategories, trans('messages.retrieve_categories'));
    }
}
