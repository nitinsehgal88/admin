<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Image;
use App\Category;
use App\Product;
use Auth;





class ProductsController extends Controller
{
    public function addProduct(Request $request){
        
        if($request->isMethod('post')){
    		$data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		if(empty($data['category_id'])){
    			return redirect()->back()->with('flash_message_error','Under Category is missing!');	
    		}
    		$product = new Product;
    		$product->category_id = $data['category_id'];
    		$product->product_name = $data['product_name'];
    		$product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->price = $data['product_price'];
            
    		if(!empty($data['description'])){
    			$product->description = $data['description'];
    		}else{
				$product->description = '';    			
    		}
    		$product->price = $data['product_price'];
			// Upload Image
			// echo "enter";
			// print_r($request->file('image'));exit;

    		if($request->hasFile('image')){
				

    			$image_tmp = $request->file('image');
    			if($image_tmp->isValid()){
    				$extension = $image_tmp->getClientOriginalExtension();
					$filename = rand(111,99999).'.'.$extension;
					$large_image_path = 'images/backend_images/products/large/';
    				// $large_image_path = 'images/backend_images/products/large/'.$filename;
    				$medium_image_path = 'images/backend_images/products/medium/'.$filename;
    				$small_image_path = 'images/backend_images/products/small/'.$filename;
					$image_tmp->move(public_path($large_image_path), $filename);
					
					
					// Resize Images
    				// Image::make($image_tmp)->save($large_image_path);
    				// Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
    				// Image::make($image_tmp)->resize(300,300)->save($small_image_path);
					
					// Store image name in products table
    				$product->image = $filename;
    			}
    		}
    		$product->save();
    		/*return redirect()->back()->with('flash_message_success','Product has been added successfully!');*/
            return redirect('/admin/view-products')->with('flash_message_success','Product has been added successfully!');
        }
        
        // $levels = Category::with('childCategory')->where(['parent_id'=>0])->get();
        $categories = Category::where(['parent_id'=>0])->get();
    	$categories_dropdown = "<option value='' selected disabled>Select</option>";
    	foreach($categories as $cat){
    		$categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."</option>";
    		$sub_categories = Category::where(['parent_id'=>$cat->id])->get();
    		foreach ($sub_categories as $sub_cat) {
    			$categories_dropdown .= "<option value = '".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }


        return view('admin.products.add_products')->with(compact('categories_dropdown'));
    }

    public function viewProduct(Request $request){
        $products = Product::get();
        return view('admin.products.view_products')->with(compact('products'));
    }
}
