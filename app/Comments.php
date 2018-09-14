<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{   
    protected $fillable = [
        'assoc_id',
        'by',  
        'comment'      
    ];

    public function association(){
        return $this->belongsTo('App\Association','assoc_id');
    }


}
