<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PredictHQ\AddressFormatter\Formatter;

class Order extends Model
{
    protected $fillable = [ 'customer', 'type', 'data', 'status', 'file', 'quantity', 'quantity_id', 'poster_cost', 
                            'etsy_transaction', 'etsy_verified', 'etsy_order', 'download',
                            'shipping_profile_id', 'shipping_code', 'shipping_method_id', 'shipping_cost'];

    public function messages() {
    	return $this->hasMany(\App\StatusMessage::class);
    }

    public function comments() {
        return $this->hasMany(\App\OrderComment::class);
    }

    public function shippingProfile() {
        return \App\ShippingProfile::where('id', $this->shipping_profile_id)->first();
    }

    public function shippingProfiles() {
        return $this->hasMany(\App\ShippingProfile::class, 'transaction_id', 'etsy_transaction');
    }

    public function shippingMethod() {
        return $this->belongsTo(\App\ShippingMethod::class);
    }

    public function getDownloadLink() {
        if($this->download) {
            return route('tracker::download', ['order' => $this->id]);
        }
        return '';
    }

    public function getTrackerUrlAttribute($value) {
        if($this->etsy_transaction) {
            return route('tracker::status', ['order' => $this->etsy_transaction]);
        }
        return route('tracker::status', ['order' => $this->id]);
    }

    public function getOrderUrlAttribute($value) {
        if($this->etsy_order) {
            return route('tracker::order', ['order' => $this->etsy_order]);
        }
        return route('tracker::status', ['order' => $this->id]);
    }

    public function isEtsyProcessed() {
        if($this->etsy_transaction) {
            if($this->etsy_verified) return true;
        }
        return false;
    }

    public function getSizeNameAttribute($value) {
        $formats = ['A4' => [210,297], 'A3' => [297,420], 'A2' => [420,594], 'A1' => [594,841], 'A0' => [840,1189]];

        if(isset($this->data->size)) {
            foreach($formats as $name => $size) {
                if($this->data->size[0] == $size[0] && $this->data->size[1] == $size[1]) {
                    return $name;
                }
            }
        }
        return null;
    }

    public function getShippingAttribute($value) {

        if($this->customer && isset($this->customer->shipping)) {

            $shipping = $this->customer->shipping;
            $first_line = (isset($shipping->first_line) ? $shipping->first_line : '');
            $second_line = (isset($shipping->second_line) ? $shipping->second_line : '');
            $zip = (isset($shipping->zip) ? $shipping->zip : '');
            $city = (isset($shipping->city) ? $shipping->city : '');
            $state = (isset($shipping->state) ? $shipping->state : '');
            $country = (isset($shipping->country) ? $shipping->country : '');

            $f = new Formatter();
            return str_replace("\n", "<br/>", $f->formatArray([
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'postcode' => $zip,
                'road' => $first_line,
                'suburb' => $second_line
            ]));
        }
    }

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

    public function setCustomerAttribute($value) {

        // If it's already mutated, let's skip any further process..
        if(!is_object($value) && !is_array($value)) return $this->attributes['customer'] = $value;

        $this->attributes['customer'] = json_encode($value);
    }
    
    public function getCustomerAttribute($value) {

    	// If it's already mutated, let's skip any further process..
    	if(is_object($value) || is_array($value)) return $value;

    	// Data attribute IS meant to be a PHP Object / Array but it is stored as serialized JSON.
    	$result = json_decode($value);
    	if($result === null) return $value;

    	return $result;
    }

    public function getUrlAttribute($value) {

    	// Validate beforehand
    	if(strlen($this->attributes['type'])) {
    		
    		// The syntax to access any editor in this application is {$type}::editor
    		return route($this->attributes['type'] . '::editor');
    	}
    	return '';
    }

    public function setStatusAttribute($value) {

        if(isset($this->attributes['status']) && isset($this->attributes['digital'])) {
        	// Init status list and corresponding status messages.
            $messages = [
                'unprocessed'   => 'The order is waiting to be processed.',
                'processed'     => 'The order is in the processing queue for final checks.',
                'printing'      => 'The order is being handled by the printing team.',
                'shipped'       => ($this->attributes['digital']) ? 'The file is now available.' : 'The order has been shipped.',
                'waiting_approval' => 'The order is awaiting approval.'
            ];

            // Loop through allowed types and messages
            foreach($messages as $type => $message) {

            	// If the new value is inside the allowed types, proceed...
                if($value == $type) {

             		// If the new order status isn't equal to the current one, then let's make a StatusMessage.
                	if($value != $this->attributes['status']) {

                		// Create StatusMessage related to this order
    	                $statusMessage = new \App\StatusMessage;
    	                $statusMessage->order_id = $this->attributes['id'];
    	                $statusMessage->message = $message;
    	                $statusMessage->save();
    	            }

    	            // Update model attribute 'status'
    	            $this->attributes['status'] = strtolower($value);
                }
            }
        }
        else $this->attributes['status'] = strtolower($value);
    }

    public function isDigital() {

    	// If the 'data' column accessor doesn't work for any reason, let's have a fallback
    	if(!is_object($this->data) && !is_array($this->data)) {

    		// Validate the data attribute
    		if(strlen($this->data)) {
    			$data = json_decode($this->data);

    			if($data === null) return null;
    		}
    		else return null;
    	}
    	else $data = $this->data;

    	if(isset($data->digital)) {
    		return $data->digital;
    	}
    	else return false;
    }
}
