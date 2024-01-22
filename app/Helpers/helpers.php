<?php
  
use Carbon\Carbon;
use App\Models\Category;  
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
 
?>