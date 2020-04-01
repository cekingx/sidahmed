<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // Orders Count
        $orders = (Object) [
            'week'      => \App\Order::all()->count(),
            'month'     => \App\Order::all()->count(),
            'pending'   => \App\Order::where('status', '==', 'unprocessed')->get()->count()
        ];

        return view('admin::index', compact('orders'));
    }
}
