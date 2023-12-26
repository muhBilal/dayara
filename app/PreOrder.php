<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class PreOrder extends Model
{
    protected $table = 'pre_orders';
    protected $fillable = ['fish_id', 'fish_size_id', 'fish_grade_id', 'qty', 'cust_name', 'cust_vehicle', 'created_at', 'updated_at'];

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string)Uuid::uuid4();
        });
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
