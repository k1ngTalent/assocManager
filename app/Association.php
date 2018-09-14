<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Association extends Model
{   
    protected $fillable = [
        'college_id',
        'name',
        'slug',        
    ];

    public function college(){
        return $this->belongsTo('App\College','college_id');
    }
    public function department(){
        return $this->hasMany('App\Department','assoc_id');
    }

    public function documents(){
        return $this->hasMany('App\Documents','assoc_id');
    }
    
    public function comments(){
        return $this->hasMany('App\Comments','assoc_id');
    }
    
}
