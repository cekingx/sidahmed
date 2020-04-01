<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Order;

class ChunkUploaderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('admin::chunk.index');
    }


    public function store(Request $request) {
        foreach($request->file('files') as $file) {
            $name = substr($file->getClientOriginalName(), 0, strpos($file->getClientOriginalName(), '.'));
            
            $order = Order::where('id', strval($name))->first();
            if($order) {
                if(!empty($order->size_name)) {
                    $name = str_slug($order->customer->name) . '-' . $order->size_name . '-' . $order->id . '.pdf';
                }
                else $name = str_slug($order->customer->name) . '-' . $order->id . '.pdf';

                $order->download = $name;
                $order->status = 'shipped';
                $order->save();

                $file->storeAs('/public/orders/', $name);
                \Mail::to(/*$order->customer->email*/"hello@sabbir.me")->send(new \App\Mail\DigitalDelivery($order));
            }
        }
    }
}
