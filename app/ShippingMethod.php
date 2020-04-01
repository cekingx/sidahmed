<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
	public $timestamps = false;
    protected $fillable = ['name', 'cost'];
}
