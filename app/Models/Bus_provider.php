<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;

class Bus_provider extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;
    protected $fillable = ["name_en", "name_vi"];
    protected $appends = ["edit_button"];

    public function getEditButtonAttribute()
    {
        return Form::lbButton("/bus/$this->id/edit", "get", "Edit", ["class" => "btn btn-xs btn-primary"])->toHtml();
    }

    public function getNameAttribute()
    {
        $key = "name_".\App::getLocale();
        return $this->attributes[$key];
    }

    public function types()
    {
        return $this->hasMany("App\Models\Bus_type", "provider_id");
    }

    public function pricesets()
    {
        return $this->hasMany("App\Models\Bus_priceset", "provider_id");
    }

    public function trips()
    {
        return $this->hasMany("App\Models\Bus_trip", "provider_id");
    }

    public function tickets()
    {
        return $this->hasManyThrough(
            'App\Models\Bus_ticket', 'App\Models\Bus_trip',
            'provider_id', 'trip_id', 'id'
        );
    }

    public function employees()
    {
        return $this->belongsToMany("App\Models\User", "bus_managers", "bus_provider_id", "user_id");
    }

    public function employee_bridges()
    {
        return $this->hasMany("App\Models\Bus_manager", "bus_provider_id");
    }

    static public function boot()
    {
    	Bus_provider::bootUuid32ModelTrait();
        Bus_provider::saving(function ($object) {
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
