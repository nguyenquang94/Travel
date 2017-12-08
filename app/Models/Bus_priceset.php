<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;

class Bus_priceset extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;
    protected $fillable = ["name_en", "name_vi", "price", "price_bwhere", "price_direct"];
    protected $appends = ["edit_button"];

    public function getEditButtonAttribute()
    {
        return Form::lbButton("/bus/$this->provider_id/priceset/$this->id/edit", "get", "Edit", ["class" => "btn btn-xs btn-primary"])->toHtml();
    }

    public function getNameAttribute()
    {
        $key = "name_".\App::getLocale();
        return $this->attributes[$key];
    }

    public function provider()
    {
        return $this->belongsTo("App\Models\Bus", "provider_id");
    }

    static public function boot()
    {
    	Bus_priceset::bootUuid32ModelTrait();
        Bus_priceset::saving(function ($object) {
        	if (Auth::user())
        	{
	            if ($object->id)
	            {
	            	$object->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$object->created_by = Auth::user()->id;
	            }
	        }
        });
    }
}
