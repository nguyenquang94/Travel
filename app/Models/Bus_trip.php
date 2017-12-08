<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;
use DB;

class Bus_trip extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;
    protected $fillable = ["name_en", "name_vi", "start_date", "start_time", "eta_date", "eta_time", "priceset_id", "type_id"];
    protected $appends = ["edit_button"];

    public function getEditButtonAttribute()
    {
        return Form::lbButton("/bus/$this->provider_id/trip/$this->id/edit", "get", "Edit", ["class" => "btn btn-xs btn-primary"])->toHtml();
    }

    public function scopeFuture($query)
    {
        return $query->where("start_date", ">=", DB::raw("now()"));
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

    public function type()
    {
        return $this->belongsTo("App\Models\Bus_type", "type_id");
    }

    public function priceset()
    {
        return $this->belongsTo("App\Models\Bus_priceset", "priceset_id");
    }

    public function tickets()
    {
        return $this->hasMany("App\Models\Bus_ticket", "trip_id");
    }

    public function ticket_available()
    {
        return $this->tickets()->available()->count();
    }

    static public function boot()
    {
    	Bus_trip::bootUuid32ModelTrait();
        Bus_trip::saving(function ($object) {
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
