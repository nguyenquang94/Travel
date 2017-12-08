<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Carbon\Carbon;
use Form;

class Hotel_room_type extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;

    protected $fillable = ["name_en", "name_vi", "adult", "child"];
    protected $appends = ["name", "price", "delete_button"];
    protected $with = ['hotel'];

    public function room_available($start_date, $end_date = false)
    {
        if ($end_date === false)
        {
            $begin = new Carbon($start_date);
            return $this->rooms()->count() - $this->order_items()->active()->where("start_date", $begin)->count();
        }
        else
        {
            $begin = new Carbon($start_date);
            $end = new Carbon($end_date);

            return $this->rooms()->available($begin, $end)->count();
        }
    }

    public function rooms()
    {
        return $this->hasMany("App\Models\Hotel_room", "room_type_id");
    }

    public function hotel()
    {
        return $this->belongsTo("App\Models\Hotel", "hotel_id");
    }

    public function getDeleteButtonAttribute()
    {
        return Form::lbButton("/hotel/".$this->hotel->id."/roomtype/$this->id/edit", "get", trans("general.edit"), ["class" => "btn btn-xs btn-primary"])->toHtml()." ".
            Form::lbButton("/hotel/".$this->hotel->id."/roomtype/$this->id", "delete", trans("general.delete"), ["class" => "btn btn-xs btn-danger"])->toHtml();
    }

    public function price($date)
    {
        $date = new Carbon($date);
        $hotel = $this->hotel;
        $priceset = $hotel->priceset_days()->whereStartDate($date)->first();
        if (!$priceset)
        {
            $priceset_weekday = $hotel->priceset_weekdays()->orderBy("start_date", "desc")->where("start_date", "<=", $date)->first();
            $list_date = [
                Carbon::SUNDAY => "sunday_priceset",
                Carbon::MONDAY => "monday_priceset",
                Carbon::TUESDAY => "tuesday_priceset",
                Carbon::WEDNESDAY => "wednesday_priceset",
                Carbon::THURSDAY => "thursday_priceset",
                Carbon::FRIDAY => "friday_priceset",
                Carbon::SATURDAY => "saturday_priceset",
            ];
            $dayOfWeek = $date->dayOfWeek;
            $priceset_key = $list_date[$dayOfWeek];
            $priceset = $priceset_weekday->$priceset_key;

            return $priceset->items()->whereRoomTypeId($this->id)->first();
        }
        else
        {
            return $priceset->priceset->items()->whereRoomTypeId($this->id)->first();
        }
    }

    public function order_items()
    {
        return $this->morphMany('App\Models\Order_item', 'info');
    }

    public function getNameAttribute()
    {
        $key = "name_".\App::getLocale();
        return $this->attributes[$key];
    }

    public function getPriceAttribute()
    {
        if (request()->has('start_date') && request()->has('end_date'))
        {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $begin = new Carbon($start_date);
            $end = new Carbon($end_date);

            $total = 0;
            for ($date = $begin->copy(); $date->lt($end); $date = $date->copy()->addDay())
            {
                $total += $this->price($date)->price;
            }
            return $total;
        }
        else
        {
            return 0;
        }
    }

    static public function boot()
    {
    	Hotel_room_type::bootUuid32ModelTrait();
        Hotel_room_type::saving(function ($type) {
        	if (Auth::user())
        	{
	            if ($type->id)
	            {
	            	$type->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$type->created_by = Auth::user()->id;
	            }
	        }
        });
        Hotel_room_type::deleting(function ($type) {
            foreach ($type->rooms as $room)
            {
                $room->delete();
            }
        });
    }
}
