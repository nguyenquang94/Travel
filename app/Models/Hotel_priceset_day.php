<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;

class Hotel_priceset_day extends Model
{
    use LBDatatableTrait;

    protected $fillable = ["start_date", "priceset_id"];

    public function priceset()
    {
    	return $this->belongsTo("App\Models\Hotel_priceset");
    }

    public function scopeInfo($query)
    {
    	return $query->with("priceset");
    }

    static public function boot()
    {
        Hotel_priceset_day::saving(function ($day) {
        	if (Auth::user())
        	{
	            if ($day->id)
	            {
	            	$day->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$day->created_by = Auth::user()->id;
	            }
	        }
        });
    }
}
