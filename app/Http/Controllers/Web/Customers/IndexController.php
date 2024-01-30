<?php

namespace App\Http\Controllers\Web\Customers;

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
            $customers = User::where('role_id','=',2)->get();
            return view('admin.customers.index',compact(['customers']));
            
        } catch (\Throwable $th) {
           
        }
    }
     /**
     * Edit Category
     */
    public function edit($id){
        try {
            
            $customer = User::where('id',$id)->first();
            return view('admin.customers.edit',compact(['customer']));
        } catch (\Throwable $th) {
            return view('admin.customers.edit',$th->getMessage());
        }
    }
}
