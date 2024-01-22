<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Product;
use Validator;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
   
class ProductController extends BaseController
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
        $products = Product::all();

        $translatedProducts = [];

        foreach ($products as $product) {
          
            // Add the translated name to the product data
            $translatedProducts[] = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'category' => getCategoryName($product->category_id)->name,
                'reviews' => $product->reviews,
                'address' => $product->address,
                'status' => $product->status,
                'created_at' => $product->created_at->format('d/m/Y'),
                'updated_at' => $product->updated_at->format('d/m/Y'),
            ];
        }
        return $this->sendResponse($translatedProducts, trans('messages.product_retrieve'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'reviews' => 'required',
            'address' => 'required',
            'status' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $product = new Product();
        $product->setTranslation('name', 'en', 'Product Name in English');
        $product->setTranslation('name', 'fr', 'Nom du produit en français');
        $product->setTranslation('name', 'ln', 'Nom du produit en lingala');
        
        $product->setTranslation('description', 'en', 'Product Description in English');
        $product->setTranslation('description', 'fr', 'Description du produit en français');
        $product->setTranslation('description', 'ln', 'Description du produit en lingala');
        
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->reviews = $request->reviews;
        $product->address = $request->address;

        $product->setTranslation('status', 'en', 'Available'); 
        $product->setTranslation('status', 'fr', 'Disponible');
        $product->setTranslation('status', 'ln', 'Elongi');
        $product->save();
       
   
        return $this->sendResponse(new ProductResource($product), trans('messages.product_create'));
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $product = Product::find($id);
  
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
   
        return $this->sendResponse(new ProductResource($product), trans('messages.product_retrieve'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $product = Product::findOrFail($id);

        // Update translations for 'name' attribute
        $product->setTranslation('name', 'en', 'Product Name in English');
        $product->setTranslation('name', 'fr', 'Nom du produit en français');
        $product->setTranslation('name', 'ln', 'Nom du produit en lingala');
        
        $product->setTranslation('description', 'en', 'Product Description in English');
        $product->setTranslation('description', 'fr', 'Description du produit en français');
        $product->setTranslation('description', 'ln', 'Description du produit en lingala');

        // Update non-translatable attributes
        $product->price = $request->input('price');

        $product->save();
   
        return $this->sendResponse(new ProductResource($product), trans('messages.product_update'));
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return $this->sendResponse([], trans('messages.product_delete'));
    }
}
