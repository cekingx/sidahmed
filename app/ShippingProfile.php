<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingProfile extends Model
{
	public $timestamps = false;
    protected $fillable = ['origin', 'destination', 'currency', 'primary_cost', 'secondary_cost', 'transaction_id'];
}