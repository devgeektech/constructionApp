<?php

namespace App\Http\Controllers\Web\Stores;

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
            $getStores = Store::all();
            return view('admin.store.index',compact(['getStores']));
            
        } catch (\Throwable $th) {
           
        }
    }

    /**
     * Edit Store
     */
    public function edit($id){
        try {
            
            $store = Store::where('id',$id)->first();
            return view('admin.store.edit',compact(['store']));
        } catch (\Throwable $th) {
            
        }
    }
    /**
     * Update Store
     */
    public function update(Request $request, $id){

        try {
           
            $request->validate([
                'name' => 'required',
                'owner' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'phone' => 'required',
            ]);
           
            $store = Store::find($id);
           
            if ($request->hasFile('logo')) {
                $logoName = 'logo-'.time().'.'.$request->logo->extension();  
                $request->logo->storeAs('public/images', $logoName);
            }
            if ($request->hasFile('banner')) {
                $bannerName = 'banner-'.time().'.'.$request->banner->extension();  
                $request->banner->storeAs('public/images', $bannerName);
            }
           
            $store->name = $request->name;
            $store->owner = $request->owner;
            $store->address = $request->address;
            $store->latitude = $request->latitude;
            $store->longitude = $request->longitude;
            $store->logo = isset($logoName) ? $logoName : $store->logo;
            $store->banner = isset($bannerName) ? $bannerName : $store->banner;
            $store->phone = $request->phone;
            $store->save();
           
            return redirect()->route('admin.stores');
        } catch (\Throwable $th) {
            return view('admin.store.edit',compact('store'));
        }
    }
}
