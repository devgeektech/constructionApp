<?php

namespace App\Http\Controllers\Api\Contributions;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use DB;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use App\Models\ProductImage;
use App\Http\Resources\StoreResource;
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
        try {
            $desiredLanguage = $request->header('Accept-Language');
            app()->setLocale($desiredLanguage);

            $get_contributions = Product::where('status',1)->where('is_contribution',1)->get();
            $contributions = ProductResource::collection($get_contributions);
            if($contributions){
                return $this->sendResponse($contributions, trans('messages.product_retrieve'));
            }
            return $this->sendResponse([], trans('messages.no_product_retrieve'));
        } catch (\Throwable $th) {
            return $this->sendError('Validation Error.', $th->getMessage());     
        }
        
        
    }
/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
   
            $validator = Validator::make($input, [
                'name' => 'required',
                'description'=> 'required',
                'price'=> 'required',
                'image'=> 'required',
                'user_id'=> 'required',
                'category_id'=> 'required',
                'store_id'=> 'required',
                'availability'=> 'required',
                'stock'=> 'required'
            ]);
    
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }

            $images = [];
            if ($request->image){
                foreach($request->image as $key => $img)
                {
                    $imageName = time() . rand(1, 99) . '.' . $img->extension();
                    $img->storeAs('public/images', $imageName);
                    $images[] = ['name' => $imageName];
                }
            }
        
            
            if (!empty($images)) {
                $firstImage = $images[0]['name'];
            }
            $contribution = new Product();
            $contribution->setTranslation('name', 'en', 'Product Name in English');
            $contribution->setTranslation('name', 'fr', 'Nom du produit en français');
            $contribution->setTranslation('name', 'ln', 'Nom du produit en lingala');
            
            $contribution->setTranslation('description', 'en', 'Product Description in English');
            $contribution->setTranslation('description', 'fr', 'Description du produit en français');
            $contribution->setTranslation('description', 'ln', 'Description du produit en lingala');
            
            $contribution->price = $request->price;
            $contribution->image = $firstImage ;
            $contribution->user_id = $request->user_id;
            $contribution->category_id = $request->category_id;
            $contribution->store_id = $request->store_id;
            $contribution->setTranslation('availability', 'en', 'Available');
            $contribution->setTranslation('availability', 'fr', 'Disponible');
            $contribution->setTranslation('availability', 'ln', 'Elongi');
            $contribution->stock = $request->stock;
            $contribution->status = 0;
            $contribution->is_contribution = $request->is_contribution;
            $contribution->save();

            foreach ($images as $key => $image) {

                $data = [
                    'user_id' => $request->user_id,
                    'product_id' => $contribution->id,
                    'name' => $image['name']
                ];
                ProductImage::create($data);
            }
            if($contribution){
                return $this->sendResponse(new ProductResource($contribution), trans('messages.product_create'));
            }
            return $this->sendResponse('Product not saved', trans('messages.product_not_create'));
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong', $th->getMessage());   
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        try {

            $contribution = Product::find($id);
  
            if (is_null($contribution)) {
                return $this->sendError('Product not found.');
            }
    
            return $this->sendResponse(new ProductResource($contribution), trans('messages.product_retrieve'));
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong', $th->getMessage());   
        }
        
    }
}
