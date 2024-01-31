<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\BannerResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\StoreResource;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Store;
use App\Models\Product;
use App\Models\ProductRatings;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class HomeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        try {
              
            $desiredLanguage = $request->header('Accept-Language');
            app()->setLocale($desiredLanguage);

            //get banners
            $get_banners = Banner::all();
            $banners = BannerResource::collection($get_banners);

            //get categories
            $get_categories = Category::all();
            $categories = CategoryResource::collection($get_categories);

            //get stores
            $get_stores = Store::all();
            $stores = StoreResource::collection($get_stores);

            //get products
            $get_products = Product::all();
            $products = ProductResource::collection($get_products);

            $responseData = [
                'banners' => $banners,
                'categories' => ($categories) ? $categories : [],
                'stores' => ($stores) ? $stores : [],
                'products' => ($products) ? $products: [],
            ];
            return $this->sendResponse($responseData, trans('messages.home_api'));
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong', $th->getMessage());     
        }
    }
}
