<?php

namespace App\Http\Controllers\Web\Banners;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Store;
use Illuminate\Support\Facades\Storage;
class IndexController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(){
        try {

            $banners = Banner::paginate(10);
            return view('admin.banners.index',compact(['banners']));
            
        } catch (\Throwable $th) {
           
        }
    }
    /**
     * Create Banner
     */
    public function create(){
        try {
            $stores = Store::paginate(10);
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
            $banner->status = 0;
            $banner->save();
            if($banner){
                $banners = Banner::paginate(10);
                return redirect()->route('admin.banners')->with('success', 'Banner Created Successfully');
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
            return redirect()->route('admin.banners')->with('success', 'Banner Updated Successfully');
        } catch (\Throwable $th) {
           
        }
    }

    /**
     * Change Status
     */
    public function changeBannerStatus(Request $request) {
        try {
            $banner = Banner::find($request->id);
            $banner->status = $request->status;
            $banner->save();
          
            if($banner){
                return response()->json(['success'=>'Status change successfully.']);
            }
            
        } catch (\Throwable $th) {
            //throw $th;
        }
       
    }

    /**
     * Search Banners
     */

     public function search(Request $request){
        $search = $request->get('search');
        if($search != ''){
           $stores = Store::where("name", 'like', '%' . $search . '%')->first();
           if($stores){
               $banners = Banner::where('store_id',$stores->id)->paginate(10);
           }
           if(count($banners )>0){
               return view('admin.banners.index',['banners'=>$banners]);
           }
           return back()->with('error','No results Found');
        }
    }

    /**
     * Delete Banner
     */
    public function destroy($id){
        $banner = Banner::find($id);
        if ($banner) {
            // If category image exists, you might want to delete it from the storage as well
            if ($banner->image) {
                Storage::delete('public/images/' . $banner->image);
            }
            
            $banner->delete();
            return redirect()->route('admin.banners')->with('success', 'Banner deleted successfully');
        } else {
            return back()->with('error', 'Banner not found');
        }
    }
}
