<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function addCategory(Request $request){
        
        if($request->method() == 'POST'){
            $data = $request->all();
            // print_r($data);exit;

            $category = new Category();
            $category->name = $data['category_name'];
            $category->parent_id = $data['parent_id'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->save();
            
            return redirect('/admin/view-categories')->with('flash_message_success','Category added Successfully');

        }
        $levels = Category::where(['parent_id'=>0])->get();
        return view('admin.categories.add_category')->with(compact('levels'));
    }

    public function viewCategories(){
        
        // $categories = Category::get();
        $categories = Category::with('parentCategory')->get();
        // echo "<pre>";
        // print_r($categories);exit;
        return view('admin.categories.view_categories')->with('categories',$categories);
    }

    public function editCategory(Request $request,$id = null){
        if($request->method() == 'POST'){
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            Category::where(['id'=>$id])->update(['parent_id'=>$data['parent_id'],'name'=>$data['category_name'],'description'=>$data['description'], 'url'=>$data['url']]);
            return redirect('/admin/view-categories')->with('flash_message_success','Category udpated successfully');

        }
        $categoryDetails = Category::where(['id'=>$id])->first();
        $levels = Category::where(['parent_id'=>0])->get();
        return view('admin.categories.edit_category')->with('categoryDetails',$categoryDetails)->with('levels',$levels);
    }


    public function deleteCategory($id = null){
        if(!empty($id)){
            Category::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Category deleted successfully');
        }
    }


}
