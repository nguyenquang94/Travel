<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Form;
use Auth;

class Bus_manager extends Model
{
	use LBDatatableTrait;
    protected $appends = ["mark_as_primary_button"];

    public function getMarkAsPrimaryButtonAttribute()
    {
        if ($this->type_id != 1)
        {
            return Form::lbButton("/bus/".$this->bus->id."/manager/$this->id", "put", "Mark as manager", ["class" => "btn btn-xs btn-success"])->toHtml();
        }
        else
        {
            return "";
        }
    }

    public function bus()
    {
    	return $this->belongsTo("App\Models\Bus_provider", "bus_provider_id");
    }
    public function user()
    {
    	return $this->belongsTo("App\Models\User", "user_id");
    }

    static public function boot()
    {
        Hotel_manager::saving(function ($area) {
        	if (Auth::user())
        	{
	            if ($area->id)
	            {
	            	$area->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$area->created_by = Auth::user()->id;
	            }
	        }
        });
    }
}
