<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function parentCategory(){
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function childCategory(){
        return $this->hasMany(self::class, 'parent_id');
    }
    
    public function categories(){
        return $this->hasMany('App\Category','parent_id');
    }

    
}
