<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\StatusMessage;

class StatusMessageController extends Controller
{
    /**
     * Create a new resource.
     * @return Response
     */
    public function store(Request $request)
    {
        $order = $request->input('order_id');
        $message = $request->input('message');

        if($message && $order) {
            $status = new StatusMessage;
            $status->order_id = $order;
            $status->message = $message;
            $status->save();
        }
        else return response()->json(['error' => 'Invalid request headers.']);
    }
}
