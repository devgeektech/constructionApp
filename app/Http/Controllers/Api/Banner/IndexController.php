<?php

namespace App\Http\Controllers\Api\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;
use App\Http\Resources\BannerResource;
class IndexController extends BaseController
{
    /**
     * Get Banners
     */
    public function index(Request $request): JsonResponse
    {
        $desiredLanguage = $request->header('Accept-Language');
        app()->setLocale($desiredLanguage);

        try {
            $get_banners = Banner::where('status',1)->paginate(20);
            $banners = BannerResource::collection($get_banners);
            if($banners){
                return $this->sendResponse($banners, trans('messages.get_banners'));
            }
            return $this->sendError('No Banner found.', ['error'=>'Unauthorised']);
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
    public function store(Request $request): JsonResponse {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'image' => 'required',
                'store_id' => 'required'
            ]);
        
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            if ($request->hasFile('image')) {
                $bannerImage = time().'.'.$request->image->extension();  
                $request->image->storeAs('public/images', $bannerImage);
            }
            
            $banner = new Banner();
            $banner->name = $bannerImage;
            $banner->store_id = $request->store_id;
            $banner->save();
            if($banner){
                return $this->sendResponse(new BannerResource($banner), trans('messages.store_banner'));
            }
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong', $th->getMessage());     
        }
        
    } 
}
