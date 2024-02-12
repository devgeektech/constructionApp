<?php

namespace App\Http\Controllers\Api\Wishlist;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\WishlistResource;
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
            $wishlist = Wishlist::with('product')->where('user_id',$this->user)->paginate(20);
            if($wishlist){
                return $this->sendResponse(WishlistResource::collection($wishlist), trans('messages.wishlist_retrieve'));
            }
            return $this->sendResponse([], trans('messages.no_wishlist_retrieve'));
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
    public function store(Request $request): JsonResponse {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'user_id' => 'required',
                'product_id' => 'required'
            ]);
        
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            
            // Check if the wishlist item already exists
            $wishlistItem = Wishlist::where('user_id', $request->user_id)
                                     ->where('product_id', $request->product_id)
                                     ->first();

            if ($wishlistItem) {
                // If the item exists, delete it
                $wishlistItem->delete();
                return $this->sendResponse([], trans('messages.remove_wishlist'));
            }
            // If the item doesn't exist, create it
            $wishlist = new Wishlist();
            $wishlist->user_id = $request->user_id;
            $wishlist->product_id = $request->product_id;
            $wishlist->save();
            return $this->sendResponse($wishlist, trans('messages.store_wishlist'));
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong', $th->getMessage());     
        }
        
    } 

    /**
     * Display a listing of products wishlist.
     *
     * @return \Illuminate\Http\Response
     */
    public function product_wishlist(Request $request): JsonResponse
    {
        try {
            $desiredLanguage = $request->header('Accept-Language');
            app()->setLocale($desiredLanguage);

            $wishlist = Wishlist::where('user_id', $this->user)
            ->whereHas('product', function ($query) {
                $query->where('is_contribution', 0);
            })
            ->with('product')
            ->paginate(20);
            if($wishlist){
                return $this->sendResponse(WishlistResource::collection($wishlist), trans('messages.wishlist_retrieve'));
            }
            return $this->sendResponse([], trans('messages.no_wishlist_retrieve'));
        } catch (\Throwable $th) {
            return $this->sendError('Validation Error.', $th->getMessage());     
        }
        
        
    }

     /**
     * Display a listing of contribution wishlist.
     *
     * @return \Illuminate\Http\Response
     */
    public function contribution_wishlist(Request $request): JsonResponse
    {
        try {
            $desiredLanguage = $request->header('Accept-Language');
            app()->setLocale($desiredLanguage);

            $wishlist = Wishlist::where('user_id', $this->user)
            ->whereHas('product', function ($query) {
                $query->where('is_contribution', 1);
            })
            ->with('product')
            ->paginate(20);
            if($wishlist){
                return $this->sendResponse(WishlistResource::collection($wishlist), trans('messages.wishlist_retrieve'));
            }
            return $this->sendResponse([], trans('messages.no_wishlist_retrieve'));
        } catch (\Throwable $th) {
            return $this->sendError('Validation Error.', $th->getMessage());     
        }
        
        
    }
}
