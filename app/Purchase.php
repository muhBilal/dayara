<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    protected $table = 'purchase';
    protected $fillable = ['code','fish_id','size_id','grade_id','qty'];

    public function fish() {
        return $this->belongsTo('App\Fish', 'fish_id');
    }

    public function grade() {
        return $this->belongsTo('App\Grade', 'grade_id');
    }

    public function size() {
        return $this->belongsTo('App\Size', 'size_id');
    }
    
}
