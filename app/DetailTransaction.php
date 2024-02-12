<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    protected $guarded = [];

    public function detail_orders(){
        return $this->belongsTo(DetailOrder::class, 'detail_order_id', 'id');
    }

    public function preorders() {
        return $this->belongsTo(PreOrder::class, 'preorder_id', 'id');
    }

    public function fishs() {
        return $this->belongsTo(Fish::class, 'fish_id', 'id');
    }
}
