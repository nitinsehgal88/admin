<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Image;
use App\Category;
use App\Product;
use App\ProductsAttribute;
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

		$products = Product::with('getProducts')->get();		
		return view('admin.products.view_products')->with(compact('products'));	
        
	}
	
	public function editProduct(Request $request , $id =null){
		if($request->isMethod('post')){
			$data = $request->all();            
			
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
    			}
			}else {
				$filename = $data['current_image'];
			}
			

			Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],
			'description'=>$data['description'],'price'=>$data['price'],'product_color'=>$data['product_color'],
			'product_code'=>$data['product_code'],'image'=>$filename]);
            return redirect('/admin/view-products')->with('flash_message_success','Product udpated successfully');
		}
		$productDetails = Product::where(['id'=>$id])->first();
		$levels = Category::where(['parent_id'=>0])->get();
		
		
		$categories = Category::where(['parent_id'=>0])->get();
    	$categories_dropdown = "<option value='' selected disabled>Select</option>";
    	foreach($categories as $cat){
			$categories_dropdown .= "<option value='".$cat->id."'";
			$categories_dropdown .= ($productDetails->category_id == $cat->id) ? 'selected' : '';
			$categories_dropdown .= ">".$cat->name."</option>";
    		$sub_categories = Category::where(['parent_id'=>$cat->id])->get();
    		foreach ($sub_categories as $sub_cat) {
				$categories_dropdown .= "<option value = '".$sub_cat->id."'";
				$categories_dropdown .= ($productDetails->category_id==$sub_cat->id) ? 'selected' : '' ;
				$categories_dropdown .= ">&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
        return view('admin.products.edit_product')->with('productDetails',$productDetails)->with('levels',$levels)->with(compact('categories_dropdown'));
	}

	public function deleteProductImage($id = null){
		Product::where(['id'=>$id])->update(['image'=>'']);
		return redirect()->back()->with('flash_message_success','Image deleted successfully');
	}

	public function deleteProduct($id =null){
		// Product::where(['id'=>$id])->delete();
		return redirect()->back()->with('flash_message_success','Product deleted successfully');
	}

	public function addAttributes(Request $request, $id = null){		
		
		if($request->isMethod('post')){
			$data = $request->all();		
			foreach($data['sku'] as $key => $val ){
				if(!empty($val)){					
					$attribute = new ProductsAttribute;
					$attribute->product_id = $id;
					$attribute->sku = $val;
					$attribute->size = $data['size'][$key];
					$attribute->price = $data['price'][$key];
					$attribute->stock = $data['stock'][$key];
					$attribute->save();
				}
			}
			$productDetails = Product::with('attributes')->where(['id'=>$id])->first();
			return view('admin.products.add_attributes')->with(compact('productDetails'));
		}

		$productDetails = Product::with('attributes')->where(['id'=>$id])->first();		
		return view('admin.products.add_attributes')->with(compact('productDetails'));
	}	

	public function deleteAttribute($id = null){
		
		ProductsAttribute::where(['id'=>$id])->delete();
		return redirect()->back()->with('flash_message_success','Product attribute deleted successfully');
	}

	public function products($url = null){
		
		$categoryUrl  = Category::where(['url' => $url])->first();
		
		$productAll = Product::where(['category_id' => $categoryUrl->id])->get();

		$categories = Category::with('categories')->where(['parent_id'=>0])->get();  
		// print_r($productAll);exit;
		// $productAll = Product::get();
		return view('products.listing')->with(compact('categoryUrl','categories','productAll'));

	}










}
