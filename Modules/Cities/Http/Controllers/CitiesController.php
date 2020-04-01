<?php

namespace Modules\Cities\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Etsy;
use App\Order;
use App\Sizes;
use App\TempImagesLinks;
use App\CustomOrderDetails;
use Intervention\Image\Facades\Image;

class CitiesController extends Controller
{
    /**r
     * Display a listing of the resource.
     * @return Response
     */
    
    public function index(Request $request,$templateId="")
    {
        $user = \Auth::user();
        $settings = [];
        $mode = 'website';
        $print = false;
        $background = null;
        
        if($request->has('etsy')) {
            $listing = Etsy::getListingFromTransaction($request->input('etsy'));

            $relationship = \App\TemplateListing::where('listing_id', $listing->listing_id)->first();

            if($relationship) {
                $template = $relationship->template;

                if($template) {
                    $settings = $template->settings;

                    $settings->etsy = $request->input('etsy');
                    $settings->templateData = ["id" => $template->id, "name" => $template->name];
                }
            }
            $mode = 'etsy';
        }
        else if($request->has('template') || !empty($templateId)) {
            $templateId = (!empty($templateId))? $templateId:$request->input('template');
            $template = \App\Template::where('id', $templateId)->first();


            if($template) {
                $settings = $template->settings;

                $settings->etsy = '';
                $settings->templateData = ["id" => $template->id, "name" => $template->name];
            }
        }
        else if($request->has('print') /*&& ($request->input('key') == 'h1uDwMpmA5u')*/) {
            $order = Order::findOrFail($request->print);

            $settings = $order->data;
            $print = true;
        }
        
        if($request->has('previewer')) {
            
            $background = \App\BackgroundImage::find($request->previewer);
            if($background) {
                $mode = 'admin-preview';
            }
        }

        if($request->has('admin')) {
            $order = Order::findOrFail($request->admin);
            $mode = 'admin';
            $settings = $order->data;
        }
        if($request->has('orderPoster')){
            $customOrderDetails = CustomOrderDetails::findOrFail($request->orderPoster);
            // echo "<pre>";print_r($customOrderDetails);die;
                    $settings = json_decode($customOrderDetails->data);
                     $settings->etsy = '';
                     $settings->order_id = $customOrderDetails->order_id;
                    $sizeLists = Sizes::all();
                    $order = $customOrderDetails;
                     // print_r($settings);die;
        }
        $sizeLists = Sizes::all();
        $countOfCart = 0;
        $cartList = \Cart::session(\Session::getId())->getContent();
        $countOfCart = count($cartList);
        return view('cities::editor.index', compact('settings', 'mode', 'order', 'print', 'background','sizeLists','countOfCart'));
    }

    public function handleEtsy(Request $request) {
        // Validate poster settings
        $settings = json_decode($request->input('settings'));
        if($settings === null) {
            return back()->with('error', 'Invalid settings.');
        }

        $settings->type = 'cities'; 

        // Detect Etsy Integration
        if($settings->etsy) {

            // Validate transaction ID
            if(!Etsy::findTransactionByID($settings->etsy)) {
                return back()->with(['error' => 'Oops! We found some problems connecting to Etsy.']);
            }

            if(Etsy::isTransactionProcessed($settings->etsy)) {
                return back()->with(['error' => 'Oops! This transaction ID has already been edited.']);
            }

            // Find an existing Etsy order, or create a new one
            $order = Etsy::createOrderFromTransactionID($settings->etsy);

            $order->data     = $settings;
            $order->status   = 'unprocessed';
            $order->file     = $request->input('preview'); // File hasn't been processed yet
            $order->etsy_verified = 1;
            $order->save();
            return redirect($order->tracker_url);        
        }
        return back()->with('error', 'Invalid settings.');
    }

    public function addToCart(Request $request) {
        
    	// Validate poster settings
    	$settings = json_decode($request->input('settings'));
        $price = 24.99;
        $name = 'Poster';
    	if($settings === null) {
    		return back()->with('error', 'Invalid Settings');
    	}

        $settings->type = 'cities';

        // Detect Etsy Integration
        if($settings->etsy) {

            // Validate transaction ID
            if(!Etsy::findTransactionByID($settings->etsy) || Etsy::isTransactionProcessed($settings->etsy)) {
                return redirect()->back();
            }

            $price = 0.00;
            $name = 'Etsy Poster';
        }

        $settings->preview = $request->input('preview');

    	// Start the cart session
    	\Cart::session(\Session::getId());

    	// Add to cart
    	\Cart::add(array(
		    'id' => random_int(0, 99999),
		    'name' => $name,
		    'price' => $price,
		    'quantity' => 1,
		    'attributes' => $settings
		));

		return redirect(route('cart'));
    }
    public function removeIteamCart($id){
        \Cart::session(\Session::getId())->remove($id);
        return redirect(route('cart'));
    }

    public function createTempLink(Request $request){
        $base64_image= $request->input('image_data');
        $orderId = @$request->input('orderId');
        $fileName = str_random(10).'.'.'png';
        $token = str_random(6);
        // $png_url = .$fileName;
       $path = public_path()."/uploads/posterImagesTemp/";
        // Image::make(file_get_contents($base64_image))->save($path); 
        if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $base64_image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_image));
        file_put_contents($path.$fileName, $base64_image);

        $expireDate = strtotime("+7 day");

        $tempImagesLinks = new TempImagesLinks;
        $tempImagesLinks->file_name = $fileName;
        $tempImagesLinks->token = $token;
        $tempImagesLinks->order_id = $orderId;
        $tempImagesLinks->expire_at = date("Y-m-d H:i:s",$expireDate );
        $tempImagesLinks->save();
        echo  route("cities::download.tempImg",$token);die;
    }

    public function viewTempImage($token){
        $current_date = date('Y-m-d H:i:s');
        $ImageInfo = TempImagesLinks::where("token",$token)->where('expire_at','>=',$current_date)->first();
        if(!empty($ImageInfo)){
           $fullPath = public_path()."/uploads/posterImagesTemp/".$ImageInfo->file_name;
             $headers = ['Content-Type' => 'image/png'];
            return response() -> file($fullPath, $headers);
        }else {
            return redirect(route('cities::editor'));
        }
    }

    public function orderPosterEditor($id){

        $user = \Auth::user();
        $settings = [];
        $mode = 'website';
        $print = false;
        $background = null;
        
        
        $customOrderDetails = CustomOrderDetails::findOrFail($id);
        $settings = $customOrderDetails->data;
        $sizeLists = Sizes::all();
        $order = $customOrderDetails;
        return view('cities::editor.index', compact('settings', 'mode', 'order', 'print', 'background','sizeLists'));
    
    }
}
