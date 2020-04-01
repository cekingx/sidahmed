<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\ShippingMethod;
use Carbon\Carbon;
use App\StatusMessage;
use App\Order;
use App\Etsy;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {

        // Fetch Etsy Orders
        $transactions = Etsy::getAllTransactions();
        $shipping_profiles = Etsy::getAllShippingProfiles();
        $shippingMethods = ShippingMethod::orderBy('id', 'desc')->get();

        // Loop thru all the transactions registered in Etsy
        foreach($transactions as $transaction) {

            // This will create orders from transaction IDs if they don't exist in our database yet
            Etsy::createOrderFromTransactionID($transaction, $shipping_profiles);
        }

        $orders = Order::where('status', '!=', 'shipped')->orderBy('id', 'desc')->get();
        foreach($orders as $idx => $order) {
            $orders[$idx]->editor_url = $order->url.'?admin='.$order->id;
        }
        return view('admin::orders.index', compact('orders', 'shippingMethods'));
    }

    public function completedOrders() {

        $orders = Order::where('status', 'shipped')->orderBy('id', 'desc')->get();
        foreach($orders as $idx => $order) {
            $orders[$idx]->editor_url = $order->url.'?admin='.$order->id;
        }

        // Calculate summary
        $summary = [];

        for($i = 1; $i != 12 + 1; $i++) {
            $summary[$i] = ['poster' => 0.00, 'shipping' => 0.00];
        }


        foreach($orders as $order) {
            $time = Carbon::createFromTimestampUTC($order->created_at->timestamp);
            $summary[$time->month]['poster']    += $order->poster_cost;
            $summary[$time->month]['shipping']  += $order->shipping_cost;
        }

        $shippingMethods = ShippingMethod::orderBy('id', 'desc')->get();

        return view('admin::orders.completed', compact('orders', 'shippingMethods', 'summary'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Order $order, Request $request) {

        $orderData = $order->data ?? (Object) [];

        if($request->has('status')) {

            $status = $request->input('status');

            if($status != $order->status) {
                if(isset($order->customer->email) && strlen($order->customer->email)) {

                    if($status == 'shipped') {
                        if(!$order->digital) {
                            \Mail::to(/*$order->customer->email*/"hello@sabbir.me")->send(new \App\Mail\ShippedProduct($order));
                        }
                    }
                    else {
                        \Mail::to(/*$order->customer->email*/"hello@sabbir.me")->send(new \App\Mail\StatusUpdate($order));
                    }
                }
            }

            $order->status = $status;
        }
        
        if($request->has('type')) {

            $type = $request->input('type');
            $order->type = $type;
        }

        if($request->has('delivery')) {

            $delivery = $request->input('delivery');
            $order->digital = $delivery;
        }

        if($request->has('size_width') && $request->has('size_height')) {

            $width = $request->input('size_width');
            $height = $request->input('size_height');

            $orderData->size = [0, 0]; // Prevent error if undefined
            $orderData->size[0] = $width;
            $orderData->size[1] = $height;
        }
        
        if($request->has('shipping_code')) {
            $order->shipping_code = $request->input('shipping_code');
        }

        if($request->has('shipping_profile_id')) {
            $order->shipping_profile_id = $request->input('shipping_profile_id');
        }

        if($request->has('file') && strlen($request->input('file'))) {
            $filename = $request->input('file');

            if(strpos($filename, '.pdf') === false) {
                $filename .= '.pdf';
            }

            \Storage::move('/public/orders/'.$order->download, '/public/orders/'.$filename);
            $order->download = $filename;   
        }

        if($request->has('shipping_method_id')) {
            $method = \App\ShippingMethod::where('id', $request->input('shipping_method_id'))->first();

            if($method) {
                $order->shipping_method_id = $method->id;
                $order->shipping_cost = $method->cost;
            }
        }

        $order->data = $orderData;
        $order->save();
    }

    public function retrieveComments(Order $order) {
        $comments = $order->comments;

        foreach($comments as $idx => $comment) {
            $comments[$idx]->user = $comment->user;
            $comments[$idx]->time = Carbon::createFromTimestampUTC($comment->created_at->timestamp)->diffForHumans();
        }
        return $comments;
    }

    public function uploadFile(Request $request) {
        $order = Order::where('id', $request->input('order_id'))->first();
        $file = base64_decode($request->file);

        if(!$order) {
            return back()->with('error', 'Oops! Something went wrong with the request.');
        }

        if(!empty($order->size_name)) {
            $name = str_slug($order->customer->name) . '-' . $order->size_name . '-' . $order->id . '.pdf';
        }
        else $name = str_slug($order->customer->name) . '-' . $order->id . '.pdf';

        $order->download = $name;
        $order->status = /*'shipped'*/ 'unprocessed';
        $order->save();

        \Storage::put('/public/orders/'.$name, $file);

        \Mail::to(/*$order->customer->email*/"hello@sabbir.me")->send(new \App\Mail\DigitalDelivery($order));
    }

    public function processOrder(Request $request) {
        $order = Order::where('id', $request->input('order_id'))->first();

        if(!$order) {
            return back()->with('error', 'Oops! Something went wrong with the request.');
        }

        if(!strlen($order->download)) {
            return back()->with('error', 'Oops! This order has no attached file yet. Process it first.');
        }

        if(!$order->isDigital()) {
            return back()->with('error', 'Oops! This order is not digital. You should proceed with shipping process.');   
        }
    }
}