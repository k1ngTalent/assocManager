<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $fillable = [
        'assoc_id',
        'path',
        'type',        
    ];
    public function association(){
        return $this->belongsTo('App\Association','assoc_id');
    }

    public function comments(){
        return $this->hasMany('App\Comments','doc_id');
    }
    // public function approval(){
    //     return $this->hasMany('App\Approval','doc_id');
    // }

    public static function entryValidationRule () {
        return [
            'email' => 'email|unique:users|required',
            'assoc_id'=>'required|exists:associations,id',
            'college_id'=>'required|exists:colleges,id',
            'assoc_slug'=>'required|exists:associations,slug',
            'coll_slug'=>'required|exists:colleges,slug',
            'doc1'=>"required|mimes:pdf|max:50000",
            'doc2'=>"required|mimes:pdf|max:50000",
            'doc3'=>"required|mimes:pdf|max:50000",
            'doc4'=>"required|mimes:pdf|max:50000",
            'doc5'=>"required|mimes:pdf|max:50000",
        ];
    }
    public static function entryUpdateValidationRule () {
        return [
            'email' => 'email|unique:users',
            'college_id'=>'required_with:email',
            'doc1'=>"nullable|mimes:pdf|max:50000",
            'doc2'=>"nullable|mimes:pdf|max:50000",
            'doc3'=>"nullable|mimes:pdf|max:50000",
            'doc4'=>"nullable|mimes:pdf|max:50000",
            'doc5'=>"nullable|mimes:pdf|max:50000",
        ];
    }

    
}
