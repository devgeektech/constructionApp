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

    protected static $user;
   
    public  function __construct() {
        self::$user = auth('sanctum')->user() ? auth('sanctum')->user()->id:null;
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

            $get_products = Product::where('status',1)->where('is_contribution',0)->paginate(20);
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
            $product->setTranslation('name', 'en', $request->name);
            $product->setTranslation('name', 'fr', $request->name);
            $product->setTranslation('name', 'ln', $request->name);
            
            $product->setTranslation('description', 'en', $request->description);
            $product->setTranslation('description', 'fr', $request->description);
            $product->setTranslation('description', 'ln', $request->description);
            
            $product->min_price = isset($request->min_price) ? $request->min_price: '0.00';

            $product->price = $request->price;
            $product->image = $firstImage ;
            $product->user_id = self::$user;
            $product->category_id = $request->category_id;
            $product->store_id = $request->store_id;
            $product->setTranslation('availability', 'en', $request->availability);
            $product->setTranslation('availability', 'fr', $request->availability);
            $product->setTranslation('availability', 'ln', $request->availability);
            $product->stock = $request->stock;
            $product->status = 0;
            $product->is_contribution = $request->is_contribution;
            $product->save();

            foreach ($images as $key => $image) {

                $data = [
                    'user_id' => self::$user,
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

            $product->setTranslation('name', 'en', $request->name);
            $product->setTranslation('name', 'fr', $request->name);
            $product->setTranslation('name', 'ln', $request->name);
            
            $product->setTranslation('description', 'en', $request->description);
            $product->setTranslation('description', 'fr', $request->description);
            $product->setTranslation('description', 'ln', $request->description);
            
            $product->min_price = isset($request->min_price) ? $request->min_price: '0.00';
            $product->price = $request->price;
            $product->image = $firstImage ;
            $product->user_id = self::$user;
            $product->category_id = $request->category_id;
            $product->store_id = $request->store_id;
            $product->setTranslation('availability', 'en', $request->availability);
            $product->setTranslation('availability', 'fr', $request->availability);
            $product->setTranslation('availability', 'ln', $request->availability);
            $product->stock = $request->stock;
            $product->status = 0;
            $product->is_contribution = $request->is_contribution;

            $product->save();
            
            foreach ($images as $key => $image) {

                $data = [
                    'user_id' => self::$user,
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
    public function destroy($id): JsonResponse
    {   
       
        $product = Product::find($id);
        
        if($product){
            ProductImage::where('product_id',$product->id)->delete();
            $product->delete();
            return $this->sendResponse(new ProductResource($product), trans('messages.product_delete'));
        }
        return $this->sendError([], 'Product Not Found!');   
    }

    /**
     * Search and filter products
     */
    public function search_and_filter_products(Request $request){

       try {
      
            $input = $request->all();

            $product_name = $input['name'] ?? null;
            $cat_id = $input['cat_id'] ?? null;
            $min_rating = $input['ratings'] ?? null;
            $min_price = $input['min_price'] ?? null;
            $max_price = $input['max_price'] ?? null;
            
            $query = Product::query();

            if ($product_name !== null) {
                $query->where(DB::raw("JSON_EXTRACT(name, '$.en')"), 'like', '%' . $product_name . '%')
                             ->orWhere(DB::raw("JSON_EXTRACT(name, '$.fr')"), 'like', '%' . $product_name . '%')
                             ->orWhere(DB::raw("JSON_EXTRACT(name, '$.ln')"), 'like', '%' . $product_name . '%')
                             ->where('is_contribution',0);
            }
            if ($cat_id !== null) {
                $query->where('category_id', $cat_id);
            }

            if ($min_rating !== null) {
                $query->whereHas('reviews', function ($subQuery) use ($min_rating) {
                    $subQuery->where('reviews', '<=', $min_rating);
                });
            }

            if ($min_price !== null || $max_price !== null) {
                $query->where('min_price', '>=', $min_price)->where('price', '<=', $max_price);
            }

            $get_products = $query->paginate(20);
           
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
           
            $get_products = Product::where('status',1)->where('category_id',$id)->paginate(20);
            $products = ProductResource::collection($get_products);
            
            if (is_null($products)) {
                return $this->sendError('Product not found.');
            } 
          
            return $this->sendResponse($products, trans('messages.product_retrieve'));
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong', $th->getMessage());   
        }
        
    }
}