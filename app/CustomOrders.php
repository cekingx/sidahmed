<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CustomOrderDetails;


class CustomOrders extends Model
{
    protected $table = "custom_orders";
    protected $primaryKey = 'id';
    protected $fillable = ['order_number', 'created_at', 'updated_at','completed','complated_at'];
    
    public static $COMPLETED_FLAG = '1';
    public static $PENDING_FLAG = '0';
    public function getMyId(){
        return $this->id;
    }
    public function getOrderNumber(){
        return $this->order_number;
    }

    public function deleteOrder($id){
    	$customOrder = CustomOrders::find($id);
    	if(!empty($customOrder)){
    	$customOrder->delete();
    	}
    	CustomOrderDetails::where('order_id', $id)->delete();
    }
    
   
}
