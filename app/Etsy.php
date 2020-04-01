<?php

namespace App;

class Etsy {

	public static function getCountryNameByID($country_id) {
		$api = Etsy::connectToApi();

		if($api) {
			$country = $api->getCountry(array('params' => array('country_id' => $country_id)));

			if($country) {
				return $country['results'][0]['name'];
			}
		}
		return null;
	}

	public static function getAllShippingProfiles() {
		$api = Etsy::connectToApi();

		$profiles = [];
		// Find user addresses
		if($api) {

			try {
				foreach(Etsy::getAllShopListings() as $listing) {
					$results = $api->findAllListingShippingProfileEntries(array('params' => array('listing_id' => $listing->listing_id)));

					if($results) {
						$profiles = array_merge($profiles, $results['results']);
					}
				}
			}
			catch(\Exception $e) {
				return null;
			}

			if($profiles) {
				return json_decode(json_encode($profiles));
			}
		}
		return null;	
	}

	public static function getReceiptTransactionsCount($receipt_id) {
		$api = Etsy::connectToApi();

		if($api) {
			$result = $api->findAllShop_Receipt2Transactions(array('params' => array('receipt_id' => $receipt_id)));

			if($result) {
				return $result['count'];
			}
		}
		return null;
	}

	public static function createOrderFromTransactionID($transaction, $shipping_profiles = null) {

		if(!$transaction) return null;

		if(!is_object($transaction) && !is_array($transaction)) {
			$transaction = Etsy::findTransactionById($transaction);
		}

		// Find out if we processed this order already
        $order = \App\Order::where('etsy_transaction', $transaction->transaction_id)->first();
        if($order) {
	        if($order->quantity > 1) {
	        	$prevOrder = $order;
	        	$order = \App\Order::where('etsy_transaction', $transaction->transaction_id)->where('etsy_verified', 0)->first();
	        	if(!$order) {
	        		$order = $prevOrder;
	        	}
	        }
	    }

        if(!$order) {
		
			// Get all shipping profiles from Etsy
 			if(!$shipping_profiles) {
				$shipping_profiles = Etsy::getAllShippingProfiles();
			}

			if($shipping_profiles) {

				// Loop thru Etsy shipping profiles and find any related to this transaction
				foreach($shipping_profiles as $profile) {
					//echo $transaction->transaction_id.'(listing: '.$transaction->listing_id.') > '.$profile->shipping_info_id.' (listing: '.$profile->listing_id.')<br/>';
					if($profile->listing_id == $transaction->listing_id) {

						$shipping_profile = null;
						$shipping_profile = \App\ShippingProfile::where('id', $profile->shipping_info_id)->where('transaction_id', $transaction->transaction_id)->first();
						if(!$shipping_profile) $shipping_profile = new \App\ShippingProfile;
						
						$shipping_profile->id 				= $profile->shipping_info_id;
						$shipping_profile->transaction_id 	= $transaction->transaction_id;
						$shipping_profile->origin 			= $profile->origin_country_name;
						$shipping_profile->destination 		= $profile->destination_country_name;
						$shipping_profile->currency 		= $profile->currency_code;
						$shipping_profile->primary_cost 	= $profile->primary_cost;
						$shipping_profile->secondary_cost 	= $profile->secondary_cost;
						$shipping_profile->save();
					}
				}
			}

            // Find a receipt linked to this transaction, this contains all the customer and shipping data
            $receipt = Etsy::getReceiptData($transaction->receipt_id);
            $customer = [];
            $etsy_order_id = null;
            if($receipt) {

                // Format the customer / shipping data to our needs.
                $customer = [
                    'name'  => $receipt->name,
                    'email' => $receipt->buyer_email,
                    'shipping' => [
                        'first_line' => $receipt->first_line,
                        'second_line' => $receipt->second_line,
                        'zip' => $receipt->zip,
                        'city' => $receipt->city,
                        'state' => $receipt->state,
                        'country' => Etsy::getCountryNameByID($receipt->country_id),
                    ]
                ];
                $etsy_order_id = $receipt->order_id;
            }

            // Determine the product type by taking a look at the TemplateListing relationship data
            $relationship = \App\TemplateListing::where('listing_id', $transaction->listing_id)->first();
            $type = '';
            $digital = 0;
            $template = false;
            if($relationship) {
            	if($relationship->template) {
            		$template = true;
            	}

                if(isset($relationship->template->type)) {
                    $type = $relationship->template->type;
                }

                // Determine delivery type
                if($relationship->delivery == 'digital') {
                	$digital = 1;
                }
                else {

                	// Search if the transaction has 'Poster Type' attribute which will determine if its print or digital
                	if(isset($transaction->variations)) {
                    	foreach($transaction->variations as $variation) {
                    		if(stripos($variation->formatted_value, 'digital') !== false) {
                    			$digital = 1;
                    		}
                    	}
                    }
                }
            }

            // Determine the status based on date
            if($transaction->creation_tsz > 1546899620) { // as of 07/01/2019
            	$status = 'unprocessed';
            	$verified = 0;
            }
            else {
            	$status = 'shipped';
            	$verified = 1;
            }

            // Determine Size
            $data = (Object) ['size' => [0.0, 0.0]];
            if(isset($transaction->variations)) {
            	foreach($transaction->variations as $variation) {
            		if(stripos($variation->formatted_name, 'size') !== false) {

            			// Find out if size is in inches format
            			if(stripos($variation->formatted_value, 'in') !== false) {

            				$arr = explode("x", strtolower($variation->formatted_value));

            				if(isset($arr[0]) && isset($arr[1])) {
            					$data->size = [floatval($arr[0]) * 25.4, floatval($arr[1]) * 25.4];
            				}
            			}
            			else if(stripos($variation->formatted_value, 'cm') !== false) {

            				$arr = explode("x", strtolower($variation->formatted_value));

            				if(isset($arr[0]) && isset($arr[1])) {
            					$data->size = [floatval($arr[0]) * 10, floatval($arr[1]) * 10];
            				}
            			}
            			else {
            				$formats = ['A4' => [210,297], 'A3' => [297,420], 'A2' => [420,594], 'A1' => [594,841], 'A0' => [840,1189]];

            				foreach($formats as $name => $meta) {
            					if($variation->formatted_value == $name) {
            						$data->size = $meta;
            					}
            				}
            			}
            		}
            	}
            }

            // Calculate Poster cost
            $posterCost = 0.00;
            if(isset($data->size) && $data->size[0]) {
            	$posterSize = \App\PosterSize::where('width', $data->size[0])->where('height', $data->size[1])->first();
            	if($posterSize) {
            		$posterCost = $posterSize->cost;
            	}
            }

            for($i = 1; $i != $transaction->quantity + 1; $i ++) {
	            $order = new Order;
	            $order->customer 		= $customer;
	            $order->type 			= $type;
	            $order->data 			= $data;
	            $order->status 			= $status;
	            $order->file 			= '';
	            $order->quantity 		= $transaction->quantity;
	            $order->quantity_id 	= $i;
	            $order->etsy_transaction= $transaction->transaction_id;
	            $order->etsy_verified 	= ($template) ? $verified : 1;
	            $order->etsy_order 		= $etsy_order_id;    
	            $order->digital 		= $digital;
	            $order->poster_cost  	= $posterCost;
	            $order->shipping_method_id = 0;
	            $order->shipping_cost 	= 0.00;
	            $order->save();
	        }

            if(isset($customer['email']) && strlen($customer['email'])) {
            	// Find out if we havent sent the order's email yet
            	if(!(Order::where('etsy_order', $etsy_order_id)->where('id', '!=', $order->id)->first())) {
	            	// Send welcome email
	            	$count = Etsy::getReceiptTransactionsCount($transaction->receipt_id);
			        if($template) {
			        	if($count > 1 || $transaction->quantity > 1) {
			        		\Mail::to(/*$customer['email']*/"hello@sabbir.me")->send(new \App\Mail\MultipleOrderWelcome($order));
			        	}
			        	else {
			        		\Mail::to(/*$customer['email']*/"hello@sabbir.me")->send(new \App\Mail\SingleOrderWelcome($order));
			        	}
			        }
			        else {
			        	\Mail::to(/*$customer['email']*/"hello@sabbir.me")->send(new \App\Mail\ManualOrderWelcome($order));
			        }
			    }
            }
		}
		return $order;
	}

	public static function getReceiptData($receipt_id) {
		$api = Etsy::connectToApi();

		try {
			$receipt = $api->getShop_Receipt2(array('params' => array('receipt_id' => $receipt_id)));
		}
		catch(\Exception $e) {
			return null;
		}

		if($receipt) {
			if(isset($receipt['results'][0]) && !empty($receipt['results'][0])) {
				return json_decode(json_encode($receipt['results'][0]));
			}
		}
		return null;
	}

	public static function getUserData($user_id) {
		$api = Etsy::connectToApi();

		try {
			$user = $api->getUser(array('params' => array('user_id' => $user_id)));
		}
		catch(\Exception $e) {
			return null;
		}

		if($user) {
			if(isset($user['results'][0]) && !empty($user['results'][0])) {
				return json_decode(json_encode($user['results'][0]));
			}
		}
		return null;
	}

	public static function getUserAddresses($user_id) {
		$api = Etsy::connectToApi();

		// Find user addresses
		if($api) {

			try {
				$address = $api->findAllUserAddresses(array('params' => array('user_id' => $user_id)));
			}
			catch(\Exception $e) {
				return null;
			}

			if($address) {
				return json_decode(json_encode($address['results']));
			}
		}
		return null;
	}

	public static function getAllTransactions() {
		$api = Etsy::connectToApi();

		// Get all available shops
		$shops = Etsy::getShops();

		$transactions = [];

		// Loop thru shops
		foreach($shops as $shop) {

			// Find all the transactions
			$shopTransactions = $api->findAllShopTransactions(array('params' => array('shop_id' => $shop->shop_id)));

			if($shopTransactions) {
				$transactions = array_merge($transactions, $shopTransactions['results']);
			}
		}

		// Convert to Object
		$transactions = json_decode(json_encode($transactions));
		return $transactions;
	}

	public static function getListingFromTransaction($transaction_id) {

		if(!$transaction_id) return [];

		$transaction = Etsy::findTransactionByID($transaction_id);
		if($transaction) {
			$listing = Etsy::findListingByID($transaction->listing_id);
			if($listing) {
				return $listing;
			}
		}
		return null;
	}

	public static function getShops() {
		$api = Etsy::connectToApi();
		$shops = $api->findAllUserShops(array('params' => array('user_id' => '__SELF__')));

		// Convert to Object
		if($shops) {
			return json_decode(json_encode($shops['results']));
		}
		return null;
	}

	public static function getAllShopListings() {

		$shops = Etsy::getShops();
		$api = Etsy::connectToApi();

		$all = [];

		foreach($shops as $shop) {
			$listings = $api->findAllShopListingsActive(array('params' => array('limit' => 100, 'include_private' => true, 'shop_id' => $shop->shop_id)))['results'];

			$all = array_merge($all, $listings);
		}

		// Convert to object and return
		return json_decode(json_encode($all));
	}

	public static function getTransactionType($transaction) {
		
		if(!is_object($transaction)) {
			$transaction = json_decode(json_encode($transaction));
		}

		if(stripos($transaction->title, 'city') !== false) return 'cities';
		else if(stripos($transaction->title, 'celestial') !== false) return 'celestial';
		return null;
	}

	public static function findTransactionByID($transaction_id) {

		if(!$transaction_id) return [];

		try {
			$api = Etsy::connectToApi();
			$transaction = json_decode(json_encode($api->getShop_Transaction(array('params' => array('transaction_id' => $transaction_id)))));

			if(isset($transaction->results[0]) && !empty($transaction->results[0])) {
				return $transaction->results[0];
			}
			return null;
		}
		catch(\Exception $e) {
			return null;
		}
	}

	public static function findListingByID($listing_id) {

		try {
			if(!$listing_id) return [];

			$api = Etsy::connectToApi();
			$listing = json_decode(json_encode($api->getListing(array('params' => array('listing_id' => $listing_id)))));

			if(isset($listing->results[0]) && !empty($listing->results[0])) {
				return $listing->results[0];
			}
			return null;
		}
		catch(\Exception $e) {
			return null;
		}
	}

	public static function isTransactionProcessed($transaction_id) {

		$order = \App\Order::where('etsy_transaction', $transaction_id)->where('etsy_verified', 1)->first();
		if($order) {
	        if($order->quantity > 1) {
	        	$order = \App\Order::where('etsy_transaction', $transaction_id)->where('etsy_verified', 0)->first();
	        	if($order) {
	        		return false;
	        	}
	        }
	        return true;
		}
		else return false;
	}

	public static function getTransactionOrderID($transaction_id) {
		$order = \App\Order::where('etsy_transaction', $transaction_id)->first();
		if($order) return $order->id;
		return null;
	}

	public static function connectToApi() {
		$auth = \Config::get('etsy');
		$client = new \Etsy\EtsyClient($auth['consumer_key'], $auth['consumer_secret']);
		$client->authorize($auth['access_token'], $auth['access_token_secret']);

		$api = new \Etsy\EtsyApi($client);
		return $api;
	}
}