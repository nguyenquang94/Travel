<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;

class Hotel_priceset_weekday extends Model
{
    use LBDatatableTrait;

    protected $fillable = ["name_en", "name_vi", "start_date", "monday_priceset_id", "tuesday_priceset_id", "wednesday_priceset_id", "thursday_priceset_id", "friday_priceset_id", "saturday_priceset_id", "sunday_priceset_id"];

    public function monday_priceset()
    {
    	return $this->belongsTo("App\Models\Hotel_priceset");
    }

    public function tuesday_priceset()
    {
    	return $this->belongsTo("App\Models\Hotel_priceset");
    }

    public function wednesday_priceset()
    {
    	return $this->belongsTo("App\Models\Hotel_priceset");
    }

    public function thursday_priceset()
    {
    	return $this->belongsTo("App\Models\Hotel_priceset");
    }

    public function friday_priceset()
    {
    	return $this->belongsTo("App\Models\Hotel_priceset");
    }

    public function saturday_priceset()
    {
    	return $this->belongsTo("App\Models\Hotel_priceset");
    }

    public function sunday_priceset()
    {
    	return $this->belongsTo("App\Models\Hotel_priceset");
    }

    public function scopeInfo($query)
    {
    	return $query->with("monday_priceset", "tuesday_priceset", "wednesday_priceset", "thursday_priceset", "friday_priceset", "saturday_priceset", "sunday_priceset");
    }
}
