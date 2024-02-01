<?php

namespace App\Http\Controllers\Web\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
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
            $categories = Category::get();
            return view('admin.categories.index',compact(['categories']));
            
        } catch (\Throwable $th) {
           
        }
    }

    /**
     * Create a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function create(){
        try {
           
            return view('admin.categories.create');
            
        } catch (\Throwable $th) {
           
        }
    }
    /**
     * Store Category
     */
    public function store(Request $request){
        try {
            $request->validate([
                'english_name' => 'required',
                'french_name' => 'required',
                'lingala_name' => 'required',
                'image' => 'required',
                'english_description' => 'required',
                'french_description' => 'required',
                'lingala_description' => 'required',
            ]);


            $category = new Category();

            if ($request->hasFile('image')) {
                $categoryImage = time().'.'.$request->image->extension();  
                $request->image->storeAs('public/images', $categoryImage);
            }
           
            $category->setTranslation('name', 'en', $request->english_name);
            $category->setTranslation('name', 'fr', $request->french_name);
            $category->setTranslation('name', 'ln', $request->lingala_name);
           
            $category->image = ($categoryImage) ? $categoryImage : $category->image;
           
            $category->setTranslation('description', 'en', $request->english_description);
            $category->setTranslation('description', 'fr', $request->french_description);
            $category->setTranslation('description', 'ln', $request->lingala_description);
            $category->status = 0;
            $category->save();
            
            return redirect()->route('admin.categories');
        } catch (\Throwable $th) {
           
        }
    }
     /**
     * Edit Category
     */
    public function edit($id){
        try {
            
            $category = Category::where('id',$id)->first();
            return view('admin.categories.edit',compact(['category']));
        } catch (\Throwable $th) {
            return view('admin.categories.edit',$th->getMessage());
        }
    }

    /**
     * Update Category
     */
    public function update(Request $request, $id){
        try {
            $request->validate([
                'english_name' => 'required',
                'french_name' => 'required',
                'lingala_name' => 'required',
            ]);


            $category = Category::find($id);
       
            $categoryImage = $request->has('image') ? $category->image : null;

            if ($request->hasFile('image')) {
                $categoryImage = time().'.'.$request->image->extension();  
                $request->image->storeAs('public/images', $categoryImage);
            }
           
            $category->setTranslation('name', 'en', $request->english_name);
            $category->setTranslation('name', 'fr', $request->french_name);
            $category->setTranslation('name', 'ln', $request->lingala_name);
           
            $category->image = ($categoryImage) ? $categoryImage : $category->image;
           
            $category->setTranslation('description', 'en', $request->english_description);
            $category->setTranslation('description', 'fr', $request->french_description);
            $category->setTranslation('description', 'ln', $request->lingala_description);
           
            $category->save();
            
            return redirect()->route('admin.categories');
        } catch (\Throwable $th) {
            return view('admin.categories.edit', compact('category'));
        }
    }
    /**
     * Delete Category
     */
    public function destroy($id){
        $category = Category::find($id);
        if ($category) {
            // If category image exists, you might want to delete it from the storage as well
            if ($category->image) {
                Storage::delete('public/images/' . $category->image);
            }
            
            $category->delete();
            return redirect()->route('admin.categories')->with('success', 'Category deleted successfully');
        } else {
            return back()->with('error', 'Category not found');
        }
    }

    /**
     * Change Status
     */
    public function changeCategoryStatus(Request $request) {
        try {
            $banner = Category::find($request->id);
            $banner->status = $request->status;
            $banner->save();
          
            if($banner){
                return response()->json(['success'=>'Status change successfully.']);
            }
            
        } catch (\Throwable $th) {
            //throw $th;
        }
       
    }
}
