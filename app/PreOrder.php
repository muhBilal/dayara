<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class PreOrder extends Model
{
    protected $table = 'pre_orders';
    protected $fillable = ['name', 'vehicle', 'status', 'created_at', 'updated_at'];


    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'order_id');
    }
}
