<?php

namespace App\Http\Controllers\Api\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
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
        try {
            $get_categories = Category::where('status',1)->get();
            $categories = CategoryResource::collection($get_categories);
            if($categories){
                return $this->sendResponse($categories, trans('messages.retrieve_categories'));
            }
            return $this->sendResponse([], trans('messages.no_categories'));
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong', $th->getMessage());     
        }
        
        
    }
}
