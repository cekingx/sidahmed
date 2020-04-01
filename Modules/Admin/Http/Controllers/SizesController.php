<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Sizes;
use Storage;

class SizesController extends Controller
{
    public function index()
    {
        $sizeList = Sizes::all()->sortBy("id");
        return view('admin::sizes.index', compact('sizeList'));
    }

    public function create(){
    	 return view('admin::sizes.form',compact('sizeInfo'));
    }

    public function store(Request $request){
       $request->validate([
            'size_name' => 'required',
            'width' => 'required',
            'height' => 'required',
        ]);
        
        Sizes::create($request->all());
        return redirect()->route('admin::sizes')
                        ->with('success','Size created successfully.');
    }
    public function edit($id){
    	$sizeInfo = Sizes::find($id);
    	if(!empty($sizeInfo)){
	    	return view('admin::sizes.form', compact('sizeInfo'));
    	} else {
            return back()->with('error', 'size not exist.');

    	}
    }

    public function update($id,Request $request){
 		$request->validate([
            'size_name' => 'required',
            'width' => 'required',
            'height' => 'required',
        ]);
        /*echo "<pre>";
        print_r($sizes);die;*/
        $sizeModel = Sizes::find($id);
        $sizeModel->setSizeName($request->input('size_name'));
        $sizeModel->setWidth($request->input('width'));
        $sizeModel->setHeight($request->input('height'));
        $sizeModel->createOrUpdate();
  
        return redirect()->route('admin::sizes')
                        ->with('success','Size updated successfully');
    }

    public function delete($id){ 
        $sizeModel = Sizes::find($id);
    	if(!empty($sizeModel)){
    		$sizeModel->delete();
    	}
    	return redirect()->route('admin::sizes')
                        ->with('success','Size deleted successfully');
    }
}
?>