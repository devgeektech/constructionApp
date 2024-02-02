<?php

namespace App\Http\Controllers\Api\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Product;
use App\Models\ProductRatings;
use App\Models\Store;
use Validator;
use DB;
use Mail; 
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use App\Models\ProductImage;
use App\Http\Resources\StoreResource;
use Illuminate\Support\Facades\Storage;
class IndexController extends BaseController
{

    protected $user;
   
    function __construct() {
        $this->user = auth('sanctum')->user() ? auth('sanctum')->user()->id:null;
    }
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
            $get_products = Product::where('status',1)->where('is_contribution',0)->get();
            $products = ProductResource::collection($get_products);
            if($products){
                return $this->sendResponse($products, trans('messages.product_retrieve'));
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
            $product = new Product();
            $product->setTranslation('name', 'en', 'Product Name in English');
            $product->setTranslation('name', 'fr', 'Nom du produit en français');
            $product->setTranslation('name', 'ln', 'Nom du produit en lingala');
            
            $product->setTranslation('description', 'en', 'Product Description in English');
            $product->setTranslation('description', 'fr', 'Description du produit en français');
            $product->setTranslation('description', 'ln', 'Description du produit en lingala');
            
            $product->price = $request->price;
            $product->image = $firstImage ;
            $product->user_id = $this->user;
            $product->category_id = $request->category_id;
            $product->store_id = $request->store_id;
            $product->setTranslation('availability', 'en', 'Available');
            $product->setTranslation('availability', 'fr', 'Disponible');
            $product->setTranslation('availability', 'ln', 'Elongi');
            $product->stock = $request->stock;
            $product->status = 0;
            $product->is_contribution = $request->is_contribution;
            $product->save();

            foreach ($images as $key => $image) {

                $data = [
                    'user_id' => $this->user,
                    'product_id' => $product->id,
                    'name' => $image['name']
                ];
                ProductImage::create($data);
            }
            if($product){

                Mail::send('email.newProduct', ['product' => $product], function($message) use($product){
                    $message->to('harvinder@geekinformatic.com');
                    $message->subject('New Product Notification');
                });

                return $this->sendResponse(new ProductResource($product), trans('messages.product_create'));
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

            $product = Product::find($id);
  
            if (is_null($product)) {
                return $this->sendError('Product not found.');
            }
            //get stores
            $get_stores = Store::orderBy('count','desc')->get();
            $stores = StoreResource::collection($get_stores);

            $responseData = [
                'product' => new ProductResource($product),
                'stores' => ($stores) ? $stores : array()
            ];
            return $this->sendResponse($responseData, trans('messages.product_retrieve'));
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong', $th->getMessage());   
        }
        
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
        try {
            $input = $request->all();
   
            $validator = Validator::make($input, [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required'
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
            $product = Product::findOrFail($id);

            $product->setTranslation('name', 'en', 'Product Name in English');
            $product->setTranslation('name', 'fr', 'Nom du produit en français');
            $product->setTranslation('name', 'ln', 'Nom du produit en lingala');
            
            $product->setTranslation('description', 'en', 'Product Description in English');
            $product->setTranslation('description', 'fr', 'Description du produit en français');
            $product->setTranslation('description', 'ln', 'Description du produit en lingala');
            
            $product->price = $request->price;
            $product->image = $firstImage ;
            $product->user_id = $this->user;
            $product->category_id = $request->category_id;
            $product->store_id = $request->store_id;
            $product->setTranslation('availability', 'en', 'Available');
            $product->setTranslation('availability', 'fr', 'Disponible');
            $product->setTranslation('availability', 'ln', 'Elongi');
            $product->stock = $request->stock;
            $product->status = 0;
            $product->is_contribution = $request->is_contribution;

            $product->save();
            
            foreach ($images as $key => $image) {

                $data = [
                    'user_id' => $this->user,
                    'product_id' => $product->id,
                    'name' => $image['name']
                ];
                ProductImage::create($data);
            }
            return $this->sendResponse(new ProductResource($product), trans('messages.product_update'));
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong', $th->getMessage());   
        }
        
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

    /**
     * Search and filter products
     */
    public function search_and_filter_products(Request $request){

       try {
      
            $input = $request->all();

            $cat_id = $input['cat_id'] ?? null;
            $min_rating = $input['ratings'] ?? null;
            $min_price = $input['min_price'] ?? null;
            $max_price = $input['max_price'] ?? null;
            
            $query = Product::query();

            if ($cat_id !== null) {
                $query->where('category_id', $cat_id);
            }

            if ($min_rating !== null) {
                $query->whereHas('reviews', function ($subQuery) use ($min_rating) {
                    $subQuery->where('reviews', '<=', $min_rating);
                });
            }

            if ($min_price !== null || $max_price !== null) {
                $query->where('price', '>=', $min_price)->where('price', '<=', $max_price);
            }

            $get_products = $query->get();
           
            $products = ProductResource::collection($get_products);
            if($products){
                return $this->sendResponse($products, trans('messages.product_retrieve'));
            }
            return $this->sendResponse([], trans('messages.no_product_retrieve'));

       } catch (\Throwable $th) {
            return $this->sendError('Something went wrong', $th->getMessage());   
       }
    }

    public function products_by_category($id){
        try {

            $product = Product::where('category_id',$id)->get();
            if (is_null($product)) {
                return $this->sendError('Product not found.');
            }
            return $this->sendResponse(new ProductResource($product), trans('messages.product_retrieve'));
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong', $th->getMessage());   
        }
        
    }
}