<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateListing extends Model
{
    protected $fillable = ['listing_id', 'template_id', 'delivery'];

    public function template() {
    	return $this->belongsTo(\App\Template::class);
    }

    public function listing(){
    	return \App\Etsy::findListingByID($this->listing_id);
    }
}
