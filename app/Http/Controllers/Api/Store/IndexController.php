<?php

namespace App\Http\Controllers\Api\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Store;
use App\Models\Product;
use Validator;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\StoreResource;
use App\Models\ProductImage;
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

            //get stores
            $get_stores = Store::where('status',1)->orderBy('count','desc')->paginate(20);
            $stores = StoreResource::collection($get_stores);

            return $this->sendResponse($stores, trans('messages.retrieve_store'));
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong', $th->getMessage());     
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
                'user_id' => 'required',
                'name' => 'required',
                'owner' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'logo' => 'required',
                'banner' => 'required',
                'phone' => 'required'
            ]);
    
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            if ($request->hasFile('logo')) {
                $logoName = time().'.'.$request->logo->extension();  
                $request->logo->storeAs('public/images', $logoName);
            }
            if ($request->hasFile('banner')) {
                $bannerName = time().'.'.$request->banner->extension();  
                $request->banner->storeAs('public/images', $bannerName);
            }
            $store = new Store();
            $store->user_id = $request->user_id;
            $store->name = $request->name;
            $store->owner = $request->owner;
            $store->address = $request->address;
            $store->latitude = $request->latitude;
            $store->longitude = $request->longitude;
            $store->logo = $logoName;
            $store->banner = $bannerName;
            $store->phone = $request->phone;
            $store->social_links = $request->social_links;
            $store->status = 0;
            $store->is_featured = 0;
            $store->count = 0;
            $store->save();
        
    
            return $this->sendResponse(new StoreResource($store), trans('messages.create_store'));
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
            $store = Store::find($id);
            if (is_null($store)) {
                return $this->sendError('Store not found.');
            }
            if($store){
                $store->count = $store->count+1;
                $store->save();

                return $this->sendResponse($store, trans('messages.store_retrieve'));
            }
            
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
                'user_id' => 'required',
                'name' => 'required',
                'owner' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'logo' => 'required',
                'banner' => 'required',
                'phone' => 'required'
            ]);
    
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            if ($request->hasFile('logo')) {
                $logoName = time().'.'.$request->logo->extension();  
                $request->logo->storeAs('public/images', $logoName);
            }
            if ($request->hasFile('banner')) {
                $bannerName = time().'.'.$request->banner->extension();  
                $request->banner->storeAs('public/images', $bannerName);
            }
            $store = Store::find($id);
          
            $store->user_id = $request->user_id;
            $store->name = $request->name;
            $store->owner = $request->owner;
            $store->address = $request->address;
            $store->latitude = $request->latitude;
            $store->longitude = $request->longitude;
            $store->logo = $logoName;
            $store->banner = $bannerName;
            $store->phone = $request->phone;
            $store->social_links = $request->social_links;
            $store->status = 0;
            $store->is_featured = 0;
            $store->count = 0;
            $store->save();
        
    
            return $this->sendResponse(new StoreResource($store), trans('messages.update_store'));
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
       
        $store = Store::find($id);
        
        if($store){
            $products = Product::where('store_id',$id)->get();
            foreach ( $products as $product) {
                ProductImage::where('product_id',$product->id)->delete();
            }
            Product::where('store_id',$id)->get();

            $store->delete();
        }
        return $this->sendResponse([], trans('messages.store_delete'));
    }
    /**
     * Get Featured Stores
     */
    public function get_featured_stores(){
        try {
            //get featured stores
            $get_stores = Store::where('is_featured',1)->paginate(20);
            $stores = StoreResource::collection($get_stores);

            return $this->sendResponse($stores, trans('messages.retrieve_store'));
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong', $th->getMessage());     
        }
    }
}
