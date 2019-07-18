@extends('layouts.adminLayout.admin_design')
@section('content')
    
<div id="content">
        <div id="content-header">
          <div id="breadcrumb"> 
            <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
            <a href="#" class="">Categories</a>
            <a href="#" class="current">View Categories</a>
         </div>
          <h1>Categories</h1>
        </div>
        <div class="container-fluid">
          <hr>
          <div class="row-fluid">
            <div class="span12">
              
              
              <div class="widget-box">
                  @if(Session::has('flash_message_error'))
                  <div class="alert alert-danger">
                     {{ Session::get('flash_message_error')}}
                  </div>
                  @endif 
                  @if(Session::has('flash_message_success'))
                  <div class="alert alert-success">
                    {{ Session::get('flash_message_success')}}
                  </div>
                  @endif 
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                  <h5>Categories</h5>
                </div>
                 
               
                <div class="widget-content nopadding">
                  <table class="table table-bordered data-table">
                    <thead>
                      <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                        <th>Parent ID</th>
                        <th>Description</th>
                        <th>Category URL</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($categories as $item)
                        <tr class="gradeU">
                            <td>{{ $item->id  }}</td>
                            <td>{{ $item->name}}</td>
                            <td>{{ !empty($item->parentCategory->name) ? $item->parentCategory->name  : 'N/A' }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->url }}</td>
                            <td class="center">
                            <a  href="{{ url('/admin/edit-category/'.$item->id) }}" class="btn btn-primary btn-mini">Edit</a> | <a id="delCat" href="{{ url('/admin/delete-category/'.$item->id) }}"  class="btn btn-danger btn-mini">Delete </a> </td>
                        </tr> 
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