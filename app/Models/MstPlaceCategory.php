<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;

class MstPlaceCategory extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;

    protected $fillable = ["name_en", "name_vi"];

    public function parent()
    {
    	return $this->belongsTo("App\Models\MstPlaceCategory", "parent_id");
    }

    public function icon()
    {
    	return $this->belongsTo("App\Models\Media", "icon_id");
    }

    static public function boot()
    {
    	MstPlaceCategory::bootUuid32ModelTrait();
        MstPlaceCategory::saving(function ($category) {
        	if (Auth::user())
        	{
	            if ($category->id)
	            {
	            	$category->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$category->created_by = Auth::user()->id;
	            }
	        }
        });
    }
}
