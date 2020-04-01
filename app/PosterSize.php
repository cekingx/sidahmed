<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosterSize extends Model
{
	public $timestamps = false;
    protected $fillable = ['name', 'width', 'height', 'unit', 'cost'];
}
