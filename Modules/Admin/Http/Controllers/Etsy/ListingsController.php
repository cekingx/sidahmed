<?php

namespace Modules\Admin\Http\Controllers\Etsy;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\TemplateListing;
use App\Etsy;
use App\Template;

class ListingsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function index() {

        $listings  = Etsy::getAllShopListings();
        $templates = Template::all();

        foreach($listings as $idx => $listing) {
        	$relationship = \App\TemplateListing::where('listing_id', $listing->listing_id)->first();
        	
        	if($relationship) {
        		$listings[$idx]->template = $relationship->template;
                $listings[$idx]->delivery = (strlen($relationship->delivery) ? $relationship->delivery : null);
        	}
        	else {
                $listings[$idx]->template = null;
                $listings[$idx]->delivery = null;
            }
        }

        return view('admin::etsy.listings.index', compact('listings', 'templates'));
    }

    public function edit(Request $request) {
        $relationship = TemplateListing::where('listing_id', $request->input('listing_id'))->first();
        if($relationship) {
            if($request->has('delivery')) {
                $relationship->delivery = $request->input('delivery');
            }

            $relationship->save();
        }
        else return response()->json(['error' => 'TemplateListing not found.']);
    }
}