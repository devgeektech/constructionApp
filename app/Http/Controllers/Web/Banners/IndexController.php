<?php

namespace App\Http\Controllers\Web\Banners;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Store;

class IndexController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(){
        try {
            $banners = Banner::all();
            return view('admin.banners.index',compact(['banners']));
            
        } catch (\Throwable $th) {
           
        }
    }
    /**
     * Create Banner
     */
    public function create(){
        try {
            $stores = Store::all();
            return view('admin.banners.create',compact(['stores']));
        } catch (\Throwable $th) {
        }
    }
    /**
     * Store Banner
     */
    public function store(Request $request){
        try {
    
            $request->validate([
                'image' => 'required',
                'store' => 'required'
            ]);
        
            if ($request->hasFile('image')) {
                $bannerImage = time().'.'.$request->image->extension();  
                $request->image->storeAs('public/images', $bannerImage);
            }
            
            $banner = new Banner();
            $banner->name = $bannerImage;
            $banner->store_id = $request->store;
            $banner->save();
            if($banner){
                $banners = Banner::all();
                return view('admin.banners.index',compact(['banners']));
            }
            
        } catch (\Throwable $th) {
          
        }
        
    } 
    /**
     * Edit Banner
     */
    public function edit($id){
        try {
            $stores = Store::all();
            $banner = Banner::where('id',$id)->first();
            return view('admin.banners.edit',compact(['banner','stores']));
        } catch (\Throwable $th) {
            return view('admin.banners.edit',$th->getMessage());
        }
    }

    /**
     * Update Banner
     */
    public function update(Request $request, $id){
      
        try {
            $request->validate([
                'store' => 'required',
            ]);
          
            $banner = Banner::find($id);
          
            $bannerImage = $request->has('image') ? $request->has('image') : $banner->name;
          
            if ($request->hasFile('image')) {
                $bannerImage = time().'.'.$request->image->extension();  
                $request->image->storeAs('public/images', $bannerImage);
            }
        
            $banner->name = $bannerImage;
            $banner->store_id = $request->store;
            $banner->save();
            
            return redirect()->route('admin.banners');
        } catch (\Throwable $th) {
           
        }
    }
}
