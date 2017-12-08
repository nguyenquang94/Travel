<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;

class Bus_type extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;
    protected $fillable = ["name_en", "name_vi"];
    protected $appends = ["edit_button"];
    protected $with = ['provider'];

    public function getEditButtonAttribute()
    {
        return Form::lbButton("/bus/$this->provider_id/type/$this->id/edit", "get", "Edit", ["class" => "btn btn-xs btn-primary"])->toHtml();
    }

    public function getNameAttribute()
    {
        $key = "name_".\App::getLocale();
        return $this->attributes[$key];
    }

    public function provider()
    {
        return $this->belongsTo("App\Models\Bus_provider", "provider_id");
    }

    static public function boot()
    {
    	Bus_type::bootUuid32ModelTrait();
        Bus_type::saving(function ($object) {
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
