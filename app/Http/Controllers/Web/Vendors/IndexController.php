<?php

namespace App\Http\Controllers\Web\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(){
        try {
            $vendors = User::where('role_id','=',3)->get();
            return view('admin.vendors.index',compact(['vendors']));
            
        } catch (\Throwable $th) {
           
        }
    }
     /**
     * Edit Category
     */
    public function edit($id){
        try {
            
            $vendor = User::where('id',$id)->first();
            return view('admin.vendor.edit',compact(['vendor']));
        } catch (\Throwable $th) {
            return view('admin.vendor.edit',$th->getMessage());
        }
    }
}
