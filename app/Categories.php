<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    //
    protected $table = 'categories';
    protected $fillable = ['name'];
    
    public function parent()
    {
        return $this->belongsTo('App\Categories', 'category_id');
    }

    public function product() {
        return $this->hasMany('App\Product'::class);
    }
}
