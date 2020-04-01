<?php

namespace Modules\Cashier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Order;
use App\CustomOrders;
use App\CustomOrderDetails;
use Mail;
use App\Mail\OrderCodeNumber;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $cartList = \Cart::session(\Session::getId())->getContent();
        /*echo "<pre>";
print_r(\Cart::session(\Session::getId())->getContent());die;
        print_r($_SESSION);die;*/
        if(count($cartList)>0){
        $cartController = new CartController;
        return view('cashier::cart.index')->with(['cartController'=>$cartController]);;
        } else {
            return redirect(route("cities::editor"));
        }
    }
    function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }
    
    public function checkout(Request $request) {
        $cart = \Cart::session(\Session::getId());

        foreach($cart->getContent() as $item) {
            $order = new Order;
            $order->customer = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'shipping' => [
                    'first_line' => $request->input('address_1'),
                    'second_line' => $request->input('address_2'),
                    'zip' => $request->input('zipcode'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'country' => $request->input('country'),
                ]
            ];
            $order->type     = $item->attributes->type;
            $order->quantity = $item->quantity;
            $order->data     = json_encode($item->attributes);
            $order->status   = 'unprocessed';
            $order->file     = $item->attributes->preview; // File hasn't been processed yet
            $order->digital  = ($item->attributes->digital) ? 1 : 0;
            $order->etsy_transaction = 0;
            $order->shipping_method_id = null;
            $order->shipping_cost = 0.0;
            $order->save();
        }

        $cart->clear();

        return redirect('/');
    }

    public function edit(Request $request) {

        if($request->has('item') && $request->has('quantity')) {
            $cart = \Cart::session(\Session::getId());
            $cart->update($request->input('item'), array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->input('quantity')
                ),
            ));
        }
    }

    public function saveCustomOrder(){
         $cart = \Cart::session(\Session::getId());
         if(count($cart->getContent())>0){
         $customOrders = new CustomOrders;
         $customOrders->save();
         $customOrderId =  $customOrders->getMyId();
         $customOrders->order_number =  sprintf("%03d", $customOrderId);
         $customOrders->save();
         $orderNumber = $customOrders->getOrderNumber();
         foreach($cart->getContent() as $item) {
            unset($item->attributes['preview']);
            $customOrdersDetails = new CustomOrderDetails;
            $customOrdersDetails->order_id = $customOrderId;
            $customOrdersDetails->order_number = $orderNumber;
            $customOrdersDetails->data = json_encode($item->attributes);
            $customOrdersDetails->title = $item->attributes['title'];
            $customOrdersDetails->location = $item->attributes['location'];
            // $customOrdersDetails->created_at = ;
            // $customOrdersDetails->updated_at = ;
            $customOrdersDetails->save();
         }
        $cart->clear();
        return redirect(route('cart.orderConfirmed',$customOrders->id));
         }
         else{
        return redirect(route('cities::editor'));
         }


    }

    public function orderConfimed($orderId){
        $customOrders = CustomOrders::find($orderId);
        if(empty($customOrders)){

            return redirect(route('cities::editor'));
        }
           $posterCounts = CustomOrderDetails::where("order_id",$customOrders->id)->count() ;
           if($posterCounts > 1){
            $redirectLink = "https://www.etsy.com/uk/listing/".$posterCounts."/";
           }else {
            $redirectLink = "https://www.etsy.com/uk/shop/paperflavors";
           }
        return view('cashier::cart.order_confirmation')->with(['customOrdersDetail'=>$customOrders,'redirectLink'=>$redirectLink]);;
        
    }

    public function sendOrderCodeEmail(Request $request){
        $email = @$request->email;
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $orderNumber = $request->orderNumber;
          Mail::to($email)->send(new OrderCodeNumber($orderNumber));
        } else {
            // return response()->json($array); // Status code here
        }
    }


}
