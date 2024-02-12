<?php
  
use Carbon\Carbon;
use App\Models\Category;  
use App\Models\Role;  
use App\Models\Store;  
use App\Models\ProductImage;  
use App\Models\Wishlist;  
use Illuminate\Support\Facades\Storage;
/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('getCategoryName')) {
    function getCategoryName($id)
    {
        $category = Category::where('id',$id)->first();
        return $category;
    }
}

if (! function_exists('getRole')) {
    function getRole($id)
    {
        $role = Role::where('id',$id)->first();
        return $role;
    }
}

if (! function_exists('getStoreName')) {
    function getStoreName($id)
    {
        $store = Store::where('id',$id)->first();
        return $store;
    }
}
if (! function_exists('getStoreAddress')) {
    function getStoreAddress($id)
    {
        $store = Store::where('id',$id)->first();
        return $store;
    }
}


if (! function_exists('getProductImages')) {
    function getProductImages($id)
    {
        $images = ProductImage::where('product_id', $id)->pluck('name')->map(function($image) {
            return asset(Storage::url('images/' . $image));
        });

        return $images;
    }
}

if (! function_exists('is_wishlist')) {
    function is_wishlist($user_id,$id)
    {
        $wishlist = Wishlist::where('user_id',$user_id)->where('product_id',$id)->first();
        if($wishlist){
            return true;
        }else{
            return false;
        }
    }
}

?>