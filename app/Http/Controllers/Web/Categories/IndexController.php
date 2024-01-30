<?php

namespace App\Http\Controllers\Web\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            $categories = Category::all();
            return view('admin.categories.index',compact(['categories']));
            
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
}
