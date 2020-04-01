<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\BackgroundImage;
use App\Template;
use App\Etsy;
use Storage;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $templates = Template::all();
        $backgroundImages = BackgroundImage::all();
        return view('admin::templates.index', compact('templates', 'backgroundImages'));
    }

    public function store(Request $request) {

        $template = new Template;
        if($request->input('template_id')) {
            $template = Template::where('id', $request->input('template_id'))->first();
        }

        if(!$template) $template = new Template;
        $template->name = $request->input('name');
        $template->type = $request->input('type');
        $template->settings = $request->input('settings');
         $template->preview = ''; 
        $template->save();

        $template->preview = 'preview_' . $template->id . '.png';
        $template->save();

        if(Storage::exists('/public/templates/'.$template->preview)) {
            Storage::delete('/public/templates/'.$template->preview);
        }

        Storage::put('/public/templates/'.$template->preview, base64_decode(substr($request->input('preview'), 22)));
        return $template;
    }

    public function attachTemplateListing(Request $request) {

        $template = $request->input('template_id');
        $listing  = $request->input('listing_id');

        $listingData = Etsy::findListingByID($listing);

        // Delete previous relationships
        \App\TemplateListing::where('listing_id', $listing)->delete();

        if($listingData) {
            $relationship = new \App\TemplateListing;
            $relationship->template_id = $template;
            $relationship->listing_id = $listing;
            $relationship->save();
        }
        else {
            return response()->json(['error' => 'Listing ID not found.']);
        }
    }

    public function downloadPreview($id) {
        $template = Template::findOrFail($id);
        if($template) {
            if($template->preview) {
                return response()->download(storage_path('app/public/templates/'.$template->preview));
            }
            return back()->with('error', 'This template has no preview file.');
        }
    }

    public function generateListingPreview(Request $request) {
        $background = \App\BackgroundImage::findOrFail($request->input('background'));
        $destination = imagecreatefrompng($background->path);
        $origin = imagecreatefromstring(base64_decode(substr($request->input('file'), 22))); // substr to remove image/png URL data

        imagecopymerge($destination, $origin, $background->data->offset[0], $background->data->offset[1], 0, 0, $background->data->size[0], $background->data->size[1], 100);

        header('Content-Type: image/png');
        imagegif($destination);

        imagedestroy($destination);
        imagedestroy($origin);
    }

    public function deleteTemplate($id){
        $template = Template::find($id);
        if(!empty($template)){
            $template->delete();
        }
        return redirect()->route('admin::templates')
                        ->with('success','Template deleted successfully'); 
    }
}
