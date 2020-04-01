<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\TempImagesLinks;
use Storage;

class ImageLinksController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // $imageLinkList = TempImagesLinks::all()->sortByDesc("id");;
        $imageLinkList = TempImagesLinks::select('temp_images_links.*','custom_orders.order_number')
                        ->leftjoin('custom_orders', 'custom_orders.id', '=', 'temp_images_links.order_id')
                        ->orderby("id","desc")
                        ->get();
        $tempImagesLinksModel = new TempImagesLinks;
        // echo $tempImagesLinksModel->getLinktoImage("ssss"); die;
        return view('admin::imagelinks.index', compact('imageLinkList','tempImagesLinksModel'));
    }

    public function delete($id){
         $imageLinkList = new TempImagesLinks;
         $imageLinkList->deleteLink($id);
         return redirect()->route('admin::imagelinks')
                        ->with('success','Image link deleted successfully');

    }
    public function edit($id){
         $imageLinkInfo = TempImagesLinks::find($id);
         $expireDate = "";
         if(!empty($imageLinkInfo)){
            $expireDate = date("Y-m-d",strtotime($imageLinkInfo->expire_at));
         }
         echo $expireDate;
    }

    public function update($id,Request $request){
        $imageLinkInfo = TempImagesLinks::find($id);
         $expireDate = "";
         if(!empty($imageLinkInfo)){
            $imageLinkInfo->expire_at = date("Y-m-d",strtotime($request->input('expiry_date')));
            $imageLinkInfo->save();
            // $expireDate = date("Y-m-d",strtotime($imageLinkInfo->expire_at));
            echo $imageLinkInfo->expire_at;
         }
    }

}
