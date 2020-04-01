<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = ['name', 'type', 'settings', 'preview'];

    public function getEditorUrl() {
        //cities::precreated-template
        if($this->type) {
           // return route($this->type . '::editor') . '?template=' . $this->id;
    	   return route('cities::precreated-template',$this->id);
        }
        return null;
    }

    public function getSettingsAttribute($value) {

    	// If it's already mutated, let's skip any further process..
    	if(is_object($value) || is_array($value)) return $value;

    	// Data attribute IS meant to be a PHP Object / Array but it is stored as serialized JSON.
    	$result = json_decode($value);
    	if($result === null) return $value;

    	return $result;
    }

    public function getDownloadPreviewUrl() {
        if($this->id) {
            return route('admin::templates.preview', ['id' => $this->id]);
        }
        return null;
    }
}
