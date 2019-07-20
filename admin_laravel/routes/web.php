<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::match(['get', 'post'], '/admin', 'AdminController@login');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/dashboard', 'AdminController@dashboard');      
    Route::get('/admin/check-pwd', 'AdminController@chkPassword');
    Route::post('/admin/update-pwd', 'AdminController@chkPassword');
    Route::match(['get', 'post'], '/admin/settings', 'AdminController@settings');

    // Category Routes
    Route::match(['get', 'post'], '/admin/add-category', 'CategoryController@addCategory');
    Route::match(['get', 'post'], '/admin/edit-category/{id}', 'CategoryController@editCategory');
    Route::match(['get', 'post'], '/admin/delete-category/{id}', 'CategoryController@deleteCategory');
    Route::get('admin/view-categories', 'CategoryController@viewCategories');

    // Products Routes
    Route::match(['get', 'post'], '/admin/add-products', 'ProductsController@addProduct');
    Route::match(['get', 'post'], '/admin/view-products', 'ProductsController@viewProduct');
    Route::match(['get', 'post'], '/admin/edit-product/{id}', 'ProductsController@editProduct');
    Route::match(['get', 'post'], '/admin/delete-product-image/{id}', 'ProductsController@deleteProductImage');
    Route::match(['get', 'post'], '/admin/delete-product/{id}', 'ProductsController@deleteProduct');

    // Product attributes
    Route::match(['get', 'post'], '/admin/add-attributes/{id}', 'ProductsController@addAttributes');
});
Route::get('/logout', 'AdminController@logout')->name('logout');  
Route::get('/home', 'HomeController@index')->name('home');


