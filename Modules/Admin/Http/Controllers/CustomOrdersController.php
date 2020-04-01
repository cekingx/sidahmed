<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\CustomOrders;
use App\CustomOrderDetails;
use Storage;

class CustomOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $customOrdersList = CustomOrders::where('completed',CustomOrders::$PENDING_FLAG)->orderBy('id', 'ASC')->get()->toArray();
        foreach ($customOrdersList as $key => $orderInfo) {
          $orderDetailsInfo =  CustomOrderDetails::where("order_id",$orderInfo['id'])->get()->toArray();
          $customOrdersList[$key]['orderDetailsInfo'] = $orderDetailsInfo;
        }
        
        return view('admin::custom-orders.index', compact('customOrdersList'));
    }

    public function delete($id){
         $customOrders = new CustomOrders;
         $customOrders->deleteOrder($id);
         return redirect()->route('admin::custom-order')
                        ->with('success','Order deleted successfully');

    }

    public function deleteCompletedOrder($id){
         $customOrders = new CustomOrders;
         $customOrders->deleteOrder($id);
         return redirect()->route('admin::custom-order.completed')
                        ->with('success','Order deleted successfully');

    }

    public function markAsCompleted($id){
         $customOrders = CustomOrders::find($id);
         if(!empty($customOrders)){
            $customOrders->completed = CustomOrders::$COMPLETED_FLAG;
            $customOrders->complated_at = now();
            $customOrders->save();
         }
         return redirect()->route('admin::custom-order')
                        ->with('success','Order has been marked as completed');

    }

    public function listCompletedOrders(){
        $customOrdersList = CustomOrders::where('completed',CustomOrders::$COMPLETED_FLAG)->orderBy('id', 'ASC')->get()->toArray();
        foreach ($customOrdersList as $key => $orderInfo) {
          $orderDetailsInfo =  CustomOrderDetails::where("order_id",$orderInfo['id'])->get()->toArray();
          $customOrdersList[$key]['orderDetailsInfo'] = $orderDetailsInfo;
        }
        
        return view('admin::custom-orders.completed_orders', compact('customOrdersList'));
    }

    /*public function delete($id){
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
    }*/

}
