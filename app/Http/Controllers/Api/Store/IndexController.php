<?php

namespace App\Http\Controllers\Api\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Store;
use Validator;
use Illuminate\Http\JsonResponse;
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
        $desiredLanguage = $request->header('Accept-Language');
        app()->setLocale($desiredLanguage);
        $stores = Store::all();

        $translatedStores = [];
        foreach ($stores as $store) {
            // Add the translated name to the product data
            $translatedStores[] = [
                'id' => $store->id,
                'user_id' => $store->user_id,
                'name' => $store->name,
                'owner' => $store->owner,
                'address' => $store->address,
                'latitude' => $store->latitude,
                'longitude' => $store->longitude,
                'logo' => asset(Storage::url('images/' . $store->logo)),
                'banner' => asset(Storage::url('images/' . $store->banner)),
                'phone' => $store->phone,
                'social_links' => $store->social_links,
                'created_at' => $store->created_at->format('d/m/Y'),
                'updated_at' =>$store->updated_at->format('d/m/Y'),
            ];
        }
        return $this->sendResponse($translatedStores, trans('messages.retrieve_store'));
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
        $store->save();
       
   
        return $this->sendResponse(new StoreResource($store), trans('messages.create_store'));
    } 
}
