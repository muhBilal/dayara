<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KedatanganRack extends Model
{
    //
    protected $table = 'kedatangan_rack';
    protected $fillable = ['kedatangan_id','rack_id'];

    public function kedatangan() {
        return $this->belongsTo('App\Kedatangan', 'kedatangan_id');
    }

    public function rack() {
        return $this->belongsTo('App\Rack', 'rack_id');
    }

}
