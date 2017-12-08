<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;

class Hotel_priceset extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;

    protected $fillable = ["name_en", "name_vi"];

    protected $appends = ["edit_button"];

    public function getEditButtonAttribute()
    {
        return Form::lbButton("/hotel/".$this->hotel->id."/priceset/$this->id/edit", "get", "Edit", ["class" => "btn btn-xs btn-primary"])->toHtml();
    }

    public function hotel()
    {
        return $this->belongsTo("App\Models\Hotel", "hotel_id");
    }

    public function roomtypes()
    {
        return $this->belongsToMany("App\Models\Hotel_room_type", "hotel_priceset_items", "priceset_id", "room_type_id");
    }

    public function items()
    {
        return $this->hasMany("App\Models\Hotel_priceset_item", "priceset_id");
    }

    static public function boot()
    {
    	Hotel_priceset::bootUuid32ModelTrait();
        Hotel_priceset::saving(function ($priceset) {
        	if (Auth::user())
        	{
	            if ($priceset->id)
	            {
	            	$priceset->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$priceset->created_by = Auth::user()->id;
	            }
	        }
        });
    }
}
