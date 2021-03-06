<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

class IndexController extends Controller
{
    public function index(){
        // Ascending ordrer
        $productAll = Product::get();

        $categories = Category::with('categories')->where(['parent_id'=>0])->get();        
        // echo "<pre>";
        // print_r($categories);exit;

        return view('index')->with(compact('productAll','categories'));
    }
}
