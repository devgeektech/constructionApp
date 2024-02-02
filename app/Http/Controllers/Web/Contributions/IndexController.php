<?php

namespace App\Http\Controllers\Web\Contributions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(){
        try {
            $contributions = Product::where('is_contribution',1)->paginate(10);
            return view('admin.contributions.index',compact(['contributions']));
            
        } catch (\Throwable $th) {
           
        }
    }
    /**
     * View Contribution
     */
    public function view($id){
        try {
            
            $contribution = Product::where('id',$id)->first();
            return view('admin.contributions.view',compact(['contribution']));
        } catch (\Throwable $th) {
            
        }
    }
    /**
     * Search Contributions
     */
    public function search(Request $request){
        $search = $request->get('search');
        if($search != ''){
           $products = Product::where(DB::raw("JSON_EXTRACT(name, '$.en')"), 'like', '%' . $search . '%')
                            ->orWhere(DB::raw("JSON_EXTRACT(name, '$.fr')"), 'like', '%' . $search . '%')
                            ->orWhere(DB::raw("JSON_EXTRACT(name, '$.ln')"), 'like', '%' . $search . '%')
                            ->where('is_contribution',1)
                            ->paginate(10);  
           $stores = Store::where("name", 'like', '%' . $search . '%')->first();
           if($stores){
               $products = Product::where('store_id',$stores->id)->where('is_contribution',1)->paginate(10);
           }
           $categories = Category::where(DB::raw("JSON_EXTRACT(name, '$.en')"), 'like', '%' . $search . '%')
                           ->orWhere(DB::raw("JSON_EXTRACT(name, '$.fr')"), 'like', '%' . $search . '%')
                           ->orWhere(DB::raw("JSON_EXTRACT(name, '$.ln')"), 'like', '%' . $search . '%')->first();
           if($categories){
               $products = Product::where('category_id',$categories->id)->where('is_contribution',1)->paginate(10);
           }
           if(count($products )>0){
               return view('admin.contributions.index',['contributions'=>$products]);
           }
           return back()->with('error','No results Found');
        }
    }

    /**
     * Change Status
     */
    public function change_contribution_status(Request $request) {
        try {
            $product = Product::find($request->id);
            $product->status = $request->status;
            $product->save();
            
            return response()->json(['success'=>'Status change successfully.']);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
