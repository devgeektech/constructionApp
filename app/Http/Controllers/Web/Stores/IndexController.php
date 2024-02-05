<?php

namespace App\Http\Controllers\Web\Stores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Mail; 
class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
        try {
            $getStores = Store::paginate(10);
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
     * View Store
     */
    public function view($id){
        try {
            
            $store = Store::where('id',$id)->first();
            return view('admin.store.view',compact(['store']));
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
           
            return redirect()->route('admin.stores')->with('success', 'Store Updated Successfully');
        } catch (\Throwable $th) {
            return view('admin.store.edit',compact('store'));
        }
    }
    /**
     * Change Status
     */
    public function changeStatus(Request $request) {
        try {
            $store = Store::find($request->id);
            $store->status = $request->status;
            $store->save();
          
            if($store){
                
                Mail::send('email.storeApproved', ['store' => $store], function($message) use($store){
                    $message->to($store->user->email);
                    $message->subject('Store Approval Notification');
                });
                return response()->json(['success'=>'Status change successfully.']);
            }
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Change Featured Status
     */
    public function isFeatured(Request $request) {
        try {
            $store = Store::find($request->id);
            $store->is_featured = $request->is_featured;
            $store->save();
            $featured_status = ($request->is_featured == 1) ? 'Featured' : 'Not Featured';
            if($store){
                return response()->json(['success'=>'Store '.$featured_status.' successfully.']);
            }
            
        } catch (\Throwable $th) {
            //throw $th;
        }
       
    }

    /**
     * Search Stores
     */

     public function search(Request $request){
        $search = $request->get('search');
        if($search != ''){
           $stores = Store::where("name", 'like', '%' . $search . '%')->paginate(10);
           if($stores){
               return view('admin.store.index',['getStores'=>$stores]);
           }
           return back()->with('error','No results Found');
        }
     }
}
