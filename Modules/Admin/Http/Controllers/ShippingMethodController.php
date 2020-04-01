<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\ShippingMethod;

class ShippingMethodController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        $shippingMethod = new ShippingMethod;
        $shippingMethod->name   = $request->input('name');
        $shippingMethod->cost   = $request->input('cost');
        $shippingMethod->save();

        return back()->with(['success' => 'The shipping method has been created']);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        $shippingMethod = ShippingMethod::where('id', $id)->first();
        if(!$shippingMethod) return response()->json(['error' => 'Shipping method not found.']);

        if($request->has('name') && strlen($request->input('name'))) {
            $shippingMethod->name = $request->input('name');
        }

        if($request->has('cost') && strlen($request->input('cost'))) {
            $shippingMethod->cost = $request->input('cost');
        }
        $shippingMethod->save();
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        ShippingMethod::where('id', $id)->delete();
    }
}
