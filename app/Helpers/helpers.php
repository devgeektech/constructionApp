<?php
  
use Carbon\Carbon;
use App\Models\Category;  
use App\Models\Role;  
use App\Models\Store;  
use App\Models\ProductImage;  
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

if (! function_exists('getProductImages')) {
    function getProductImages($id)
    {
        $images = ProductImage::where('product_id',$id)->pluck('name');
        return $images;
    }
}

?>