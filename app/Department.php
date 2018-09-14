<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{   
    protected $fillable = [
        'name',
        'slug',
        'assoc_id',
        'approved'    
    ];

    public function association(){
        return $this->belongsTo('App\Association','assoc_id');
    }

}
