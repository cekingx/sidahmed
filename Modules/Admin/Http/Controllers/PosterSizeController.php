<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\ShippingMethod;
use App\PosterSize;

class PosterSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $posterSizes = PosterSize::orderBy('id', 'desc')->get();
        $shippingMethods = ShippingMethod::orderBy('id', 'desc')->get();
        return view('admin::invoice.index', compact('posterSizes', 'shippingMethods'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        $posterSize = new PosterSize;
        $posterSize->name   = $request->input('name');
        $posterSize->unit   = $request->input('unit');
        $posterSize->width  = $request->input('width');
        $posterSize->height = $request->input('height');
        $posterSize->cost   = $request->input('cost');
        $posterSize->save();

        return back()->with(['success' => 'The poster size has been created']);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        $posterSize = PosterSize::where('id', $id)->first();
        if(!$posterSize) return response()->json(['error' => 'Poster size not found.']);

        if($request->has('name') && strlen($request->input('name'))) {
            $posterSize->name = $request->input('name');
        }

        if($request->has('unit') && strlen($request->input('unit'))) {
            $posterSize->unit = $request->input('unit');
        }

        if($request->has('width') && strlen($request->input('width'))) {
            $posterSize->width = $request->input('width');
        }

        if($request->has('height') && strlen($request->input('height'))) {
            $posterSize->height = $request->input('height');
        }

        if($request->has('cost') && strlen($request->input('cost'))) {
            $posterSize->cost = $request->input('cost');
        }
        $posterSize->save();
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        PosterSize::where('id', $id)->delete();
    }
}
