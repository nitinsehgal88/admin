@extends('layouts.adminLayout.admin_design')
@section('content')
  
<div id="content">
        <div id="content-header">
        <div id="breadcrumb"> <a href="{{ url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom">
              <i class="icon-home"></i> Products</a> 
              <a href="#" class="current">Add Product</a> </div>
          <h1>Products</h1>
        </div>
        <div class="container-fluid"><hr>
          
            <div class="row-fluid">
                <div class="span12">
                  <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                      <h5>Add Attribute </h5>
                    </div>
                        <div class="widget-content nopadding">                    
                            <form class="form-horizontal" method="post" action="{{ url('/admin/add-attributes/'.$productDetails->id) }}" name="add_attributes" id="add_attributes" 
                            enctype="multipart/form-data">
                                {{ csrf_field() }}
                                
                            <div class="control-group">
                               <label class="control-label">Product Name</label>
                                <label class="control-label"><strong>{{ $productDetails->product_name }}</strong></label>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Product Code</label>
                                <label class="control-label"><strong>{{ $productDetails->product_code }}</strong></label>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Product Color</label>
                                <label class="control-label"><strong>{{ $productDetails->product_color }}</strong></label>
                            </div>
                                
                            <div class="control-group">
                                <label class="control-label">Product Attribute</label>
                                <div class="field_wrapper">
                                    <div>
                                        <input required type="text" name="sku[]" placeholder="SKU" value="" id="sku" style="width:100px"/>
                                        <input required type="text" name="size[]" placeholder="SIZE" value="" id="size" style="width:100px"/>
                                        <input required  onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="price[]" placeholder="PRICE"  value="" id="price" style="width:100px"/>
                                        <input required type="number" name="stock[]"  placeholder="STOCK" value="" id="stock" style="width:100px"/>
                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                    </div>
                                </div>
                            </div>
                            
                        <div class="form-actions">
                          <input type="submit" value="Add Product" class="btn btn-success">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
           
          </div>


          <hr>
          <div class="row-fluid">
            <div class="span12">
              <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                  <h5>View Products</h5>
                </div>
                <div class="widget-content nopadding">
                  <table class="table table-bordered data-table">
                    <thead>
                      <tr>
                        <th>Attrbute ID</th>
                        <th>Attrbute Sku</th>
                        <th>Attrbute Price</th>
                        <th>Attrbute Size</th>
                        <th>Attrbute Stock</th>                        
                        <th>Action</th>                        
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($productDetails['attributes'] as $product)
                      <tr class="gradeX">
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->price}}</td>
                        <td>{{ $product->size }}</td>
                        <td>{{ $product->stock }}</td>   
                        <td>
                          <a rel="{{ $product->id}}"  rell="delete-attribute" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a>                                            
                        </td>
                      @endforeach
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
      

@endsection