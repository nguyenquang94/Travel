<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;
use Carbon\Carbon;

class Hotel extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;
    
	protected $fillable = [
        "name_en", "name_vi", 
        "name_in_url_en", "name_in_url_vi", 
        "description_en", "description_vi", 
        "short_description_en", "short_description_vi", 
        "how_to_go_en", "how_to_go_vi",
        "address_en", "address_vi", "image_id",
        "enable_en", "enable_vi",
        "latitude", "longitude", "zoom",
        "policy_en", "policy_vi", "commission"];

    protected $appends = ["edit_button", "min_price"];

    public function places()
    {
        return $this->belongsToMany("App\Models\Place", "place_hotels", "hotel_id", "place_id");
    }

    public function priceset_weekdays()
    {
        return $this->hasMany("App\Models\Hotel_priceset_weekday", "hotel_id");
    }

    public function active_priceset_weekdays()
    {
        return $this->hasMany("App\Models\Hotel_priceset_weekday", "hotel_id")->orderBy("start_date", "desc");
    }

    public function priceset_days()
    {
        return $this->hasMany("App\Models\Hotel_priceset_day", "hotel_id");
    }

    public function areas()
    {
        return $this->hasMany("App\Models\Hotel_area", "hotel_id");
    }

    public function roomtypes()
    {
        return $this->hasMany("App\Models\Hotel_room_type", "hotel_id");
    }

    public function rooms()
    {
        return $this->hasMany("App\Models\Hotel_room", "hotel_id");
    }

    public function pricesets()
    {
        return $this->hasMany("App\Models\Hotel_priceset", "hotel_id");
    }

    public function employees()
    {
        return $this->belongsToMany("App\Models\User", "hotel_managers", "hotel_id", "user_id");
    }

    public function employee_bridges()
    {
        return $this->hasMany("App\Models\Hotel_manager", "hotel_id");
    }

    public function getEditButtonAttribute()
    {
        return Form::lbButton("/hotel/$this->id/edit", "get", "Edit", ["class" => "btn btn-xs btn-primary"])->toHtml();
    }

    public function getMinPriceAttribute()
    {
        if (request()->has('start_date') && request()->has('end_date'))
        {
            $min = -1;
            foreach ($this->roomtypes()->get() as $roomtype)
            {
                if ($min == -1)
                {
                    $min = $roomtype->price;
                }
                if ($min > $roomtype->price)
                {
                    $min = $roomtype->price;
                }
            }
            return $min;
        }
        else
        {
            return 0;
        }
    }

    public function getMaxPriceAttribute()
    {
        $max = 0;
        if (request()->has('start_date') && request()->has('end_date'))
        {
            foreach ($this->roomtypes()->get() as $roomtype)
            {
                if ($max == 0)
                {
                    $max = $roomtype->price;
                }
                if ($max < $roomtype->price)
                {
                    $max = $roomtype->price;
                }
            }
        }
        return $max;
    }

    public function media()
    {
        return $this->belongsToMany("App\Models\Media", "place_media", "place_id", "media_id");
    }

    public function scopeAvailable($query, $start_date, $end_date)
    {
        return $query->whereHas("rooms", function($query1) use ($start_date, $end_date) {
            $begin = new Carbon($start_date);
            $end = new Carbon($end_date);
            $query1->available($begin, $end);
        });
    }
}
