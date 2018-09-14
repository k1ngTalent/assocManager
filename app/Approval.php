<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $fillable = [
        'assoc_id',
        'approved',  
        'by'     
    ];


    public function associations(){
        return $this->belongsTo('App\Association','assoc_id');
    }

    
    

    
}
