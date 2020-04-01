<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackgroundImage extends Model
{
    protected $fillables = ['name', 'data', 'file'];

 	public function setDataAttribute($value) {

        // If it's already mutated, let's skip any further process..
        if(!is_object($value) && !is_array($value)) return $this->attributes['data'] = $value;

        $this->attributes['data'] = json_encode($value);
    }

    public function getDataAttribute($value) {

        // If it's already mutated, let's skip any further process..
        if(is_object($value) || is_array($value)) return $value;

        // Data attribute IS meant to be a PHP Object / Array but it is stored as serialized JSON.
        $result = json_decode($value);
        if($result === null) return $value;

        return $result;
    }

    public function getPathAttribute($value) {
    	return asset('storage/background_images/'.$this->attributes['file']);
    }
}
