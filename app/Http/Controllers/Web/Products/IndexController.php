<?php

namespace App\Http\Controllers\Web\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;

class IndexController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(){
        try {
            $stores = Store::count();
            $products = Product::count();
            $categories = Category::count();
            $users = User::count();
            $getProducts = Product::all();
            return view('admin.products.index',compact(['stores','products','categories','users','getProducts']));
            
        } catch (\Throwable $th) {
           
        }
    }
}
