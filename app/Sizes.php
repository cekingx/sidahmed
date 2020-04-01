<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sizes extends Model
{

  public function setSizeName($sizeName){
  	$this->size_name = $sizeName;
  }

  public function setWidth($width){
  	$this->width = $width;
  }

  public function setHeight($height){
  	$this->height = $height;
  }

  public function createOrUpdate(){
  	return $this->save();
  }

 public $timestamps = true;
 protected $table = 'sizes'; 
 protected $fillable = ['size_name', 'width', 'height'];

}