<?php

namespace Modules\Tracker\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Order;
use App\Etsy;

class TrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        return view('tracker::index');
    }

    public function status($order_id) {

        $transaction = Etsy::findTransactionById($order_id);
        if(!$transaction) {
            return redirect('/tracker')->with('error', 'Oops! We could not find that transaction ID. Perhaps you are confusing it with the Order ID?');
        }

        $order = Etsy::createOrderFromTransactionID($transaction);

        // If the order has multiple items, then let's send the user to the order page
        if($order->quantity > 1) {
            return redirect(route('tracker::order', ['order' => $order->etsy_order]));
        }

        if($order->etsy_verified) {

            // If transaction is already processed, then send to the tracker status page.
            $checks = ['unactive', 'unactive', 'unactive', 'unactive'];

            if($order->status == 'unprocessed') {
                $checks[0] = 'active';
            }
            else if($order->status == 'processed') {
                $checks[0] = 'active';
                $checks[1] = 'active';
            }
            else if($order->status == 'printing') {
                $checks[0] = 'active';
                $checks[1] = 'active';
                $checks[2] = 'active';
            }
            else if($order->status == 'shipped') {
                $checks[0] = 'active';
                $checks[1] = 'active'; 
                $checks[2] = 'active';
                $checks[3] = 'active';
            }
            return view('tracker::status.index', compact('order', 'checks'));
        }
        else {
            // Redirect to editor
            return redirect($order->url.'?etsy='.$transaction->transaction_id);
        }
    }

    public function etsyOrder($order_id) {
        $orders = Order::where('etsy_order', $order_id)->get();
        return view('tracker::order.index', compact('orders'));
    }

    public function download($order_id) {
        $order = Order::findOrFail($order_id);
        if($order->download) {
            return response()->download(storage_path('app/public/orders/'.$order->download));
        }
        return redirect('/');
    }
}