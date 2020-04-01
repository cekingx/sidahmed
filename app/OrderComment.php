<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderComment extends Model
{
    protected $fillable = ['user_id', 'order_id', 'content'];

    public function user() {
    	return $this->belongsTo(\App\User::class);
    }

    public function order() {
    	return $this->belongsTo(\App\Order::class);
    }
}
