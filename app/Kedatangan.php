<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kedatangan extends Model
{
    //
    protected $table = 'kedatangan';
    protected $fillable = ['code', 'date', 'warehouse_id', 'urutan', 'fish_id', 'size_id', 'grade_id', 'supplier_id', 'qty', 'kontainer'];

    public function kedatanganRack()
    {
        return $this->hasMany('App\KedatanganRack', 'kedatangan_id');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse', 'warehouse_id');
    }

    public function fish()
    {
        return $this->belongsTo('App\Fish', 'fish_id');
    }

    public function grade()
    {
        return $this->belongsTo('App\Grade', 'grade_id');
    }

    public function size()
    {
        return $this->belongsTo('App\Size', 'size_id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'supplier_id');
    }

}
