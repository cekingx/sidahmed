<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\BackgroundImage;

class BackgroundImageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $backgrounds = BackgroundImage::all();
        return view('admin::backgrounds.index', compact('backgrounds'));
    }


    public function store(Request $request) {

        if(!$request->hasFile('file')) {
            return response()->json(['error' => 'File parameter not found.'], 406);
        }

        $file = $request->file('file');

        $file->store('public/background_images/');

        $background = new BackgroundImage;
        $background->name = $request->input('name');
        $background->data = json_decode($request->input('data'));
        $background->file = $file->hashName();
        $background->save();
        return back();
    }

    public function update(Request $request) {

        $background = BackgroundImage::where('id', $request->input('background_image_id'))->first();
        if($background) {

            if($request->has('name') && strlen($request->input('name'))) {
                $background->name = $request->input('name');
            }

            if($request->has('data') && strlen($request->input('data'))) {
                $background->data = $request->input('data');
            }

            if($request->hasFile('file')) {

                $file = $request->file('file');

                // Delete previous background image
                \Storage::delete('public/background_images/'.$background->attributes['path']);

                $background->file = $file->hashName();

                $file->store('public/background_images/');
            }

            $background->save();
        }
        else return response()->json(['error' => 'BackgroundImage not found.']);
    }

    public function destroy(Request $request) {

        $background = BackgroundImage::where('id', $request->input('background_image_id'))->first();
        if($background) {
            \Storage::delete('public/background_images/'.$background->attributes['path']);
            $background->delete();
        }
        else return response()->json(['error' => 'BackgroundImage not found.']);
    }
}
