<?php

namespace App\Http\Controllers\Web\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Mail; 
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
            $getProducts = Product::where('is_contribution',0)->paginate(10);
            return view('admin.products.index',compact(['getProducts']));
            
        } catch (\Throwable $th) {
           
        }
    }
    /**
     * View Product
     */
    public function view($id){
        try {
            
            $product = Product::where('id',$id)->first();
            return view('admin.products.view',compact(['product']));
        } catch (\Throwable $th) {
            
        }
    }
    
    /**
     * Change Status
     */
    public function change_product_status(Request $request) {
        try {
            $product = Product::find($request->id);
            $product->status = $request->status;
            $product->save();
            if($product){
                
                Mail::send('email.productApproved', ['store' => $product], function($message) use($product){
                    $message->to($product->user->email);
                    $message->subject('Product Approval Notification');
                });
                return response()->json(['success'=>'Status change successfully.']);
            }
            return response()->json(['success'=>'Status change successfully.']);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    /**
     * Search Products
     */
    public function search(Request $request){
         $search = $request->get('search');
         if($search != ''){
            $products = Product::where(DB::raw("JSON_EXTRACT(name, '$.en')"), 'like', '%' . $search . '%')
                             ->orWhere(DB::raw("JSON_EXTRACT(name, '$.fr')"), 'like', '%' . $search . '%')
                             ->orWhere(DB::raw("JSON_EXTRACT(name, '$.ln')"), 'like', '%' . $search . '%')
                             ->where('is_contribution',0)
                             ->paginate(10);  
            $stores = Store::where("name", 'like', '%' . $search . '%')->first();
            if($stores){
                $products = Product::where('store_id',$stores->id) ->where('is_contribution',0)->paginate(10);
            }
            $categories = Category::where(DB::raw("JSON_EXTRACT(name, '$.en')"), 'like', '%' . $search . '%')
                            ->orWhere(DB::raw("JSON_EXTRACT(name, '$.fr')"), 'like', '%' . $search . '%')
                            ->orWhere(DB::raw("JSON_EXTRACT(name, '$.ln')"), 'like', '%' . $search . '%')->first();
            if($categories){
                $products = Product::where('category_id',$categories->id) ->where('is_contribution',0)->paginate(10);
            }
            if(count($products )>0){
                return view('admin.products.index',['getProducts'=>$products]);
            }
            return back()->with('error','No results Found');
     }
 }
}
