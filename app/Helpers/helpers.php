<?php
  
use Carbon\Carbon;
use App\Models\Category;  
use App\Models\Role;  
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

?>