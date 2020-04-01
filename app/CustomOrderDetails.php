<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomOrderDetails extends Model
{
    protected $table = "custom_order_details";
    protected $primaryKey = 'id';
    protected $fillable = ['order_id','order_number','data','title','location', 'created_at', 'updated_at'];
    
    public function getMyId(){
        return $this->id;
    }
    public function getOrderNumber(){
        return $this->order_number;
    }
    
   
}
