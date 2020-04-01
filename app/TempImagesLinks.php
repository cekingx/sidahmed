<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempImagesLinks extends Model
{
    protected $table = "temp_images_links";
    protected $primaryKey = 'id';
    protected $fillable = ['file_name', 'token','order_id', 'created_at', 'expire_at'];
    
    public function getLinktoImage($token){
    	return  route("cities::download.tempImg",$token);
    }

    public function deleteLink($id){
    	$tempImagesLinks = TempImagesLinks::find($id);
    	if(!empty($tempImagesLinks)){
    		$fullPath = public_path()."/uploads/posterImagesTemp/".$tempImagesLinks->file_name;
    		if(file_exists($fullPath)){
    			unlink($fullPath);
    		}
    		$tempImagesLinks->delete();
    	}
    }
   
}
