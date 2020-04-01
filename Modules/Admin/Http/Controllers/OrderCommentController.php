<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\OrderComment;
use App\Order;
use Auth;

class OrderCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Order $order, Request $request) {

        $comment = new OrderComment;
        $comment->order_id = $order->id;
        $comment->user_id = Auth::user()->id;
        $comment->content = $request->input('content');
        $comment->save();
    }


    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
