<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $table = 'detail_orders';
    protected $fillable = ['fish_id', 'fish_size_id', 'fish_grade_id', 'qty', 'status', 'created_at', 'updated_at'];

    public function preOrder()
    {
        return $this->belongsTo(PreOrder::class, 'order_id');
    }
    public function order()
    {
        return $this->belongsTo('App\PreOrder', 'order_id');
    }

    public function fish()
    {
        return $this->belongsTo('App\Fish', 'fish_id');
    }

    public function grade()
    {
        return $this->belongsTo('App\Grade', 'fish_grade_id');
    }

    public function size()
    {
        return $this->belongsTo('App\Size', 'fish_size_id');
    }

}
