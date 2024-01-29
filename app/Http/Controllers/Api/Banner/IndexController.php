<?php

namespace App\Http\Controllers\Api\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;

class IndexController extends BaseController
{
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
                'image' => 'required'
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
            $banner->save();
            if($banner){
                return $this->sendResponse($banner, trans('messages.store_banner'));
            }
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong', $th->getMessage());     
        }
        
    } 
}
