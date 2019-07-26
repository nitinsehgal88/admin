<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function getProducts(){
        // return $this->hasOne('App\Category', 'id','category_id');
        return $this->belongsTo('App\Category', 'category_id','id');
    }

    public function attributes(){
        return $this->hasMany('App\ProductsAttribute','product_id');
    }
}
