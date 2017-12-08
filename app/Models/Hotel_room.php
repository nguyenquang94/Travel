<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;
use Carbon\Carbon;
use App\Models\Hotel_room_type;

class Hotel_room extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;

    protected $fillable = ["name_en", "name_vi", "room_type_id", "area_id"];
    protected $appends = ["edit_button", "delete_button"];

    public function roomtype()
    {
        return $this->belongsTo("App\Models\Hotel_room_type", "room_type_id");
    }

    public function area()
    {
        return $this->belongsTo("App\Models\Hotel_area", "area_id");
    }

    public function getEditButtonAttribute()
    {
        return Form::lbButton("/hotel/$this->hotel_id/room/$this->id/edit", "get", "Edit", ["class" => "btn btn-xs btn-primary"])->toHtml();
    }

    public function getDeleteButtonAttribute()
    {
        return Form::lbButton("/hotel/$this->hotel_id/room/$this->id", "delete", "Delete", ["class" => "btn btn-xs btn-danger"])->toHtml();
    }

    public function scopeAvailable($query, $start_date, $end_date)
    {
        return $query->whereHas('order_items', function ($query) use ($start_date, $end_date) {
            $query->where("start_date", ">=", $start_date)->where("start_date", "<", $end_date)->active();
        }, 0);
    }

    public function order_items()
    {
        return $this->morphMany('App\Models\Order_item', 'product');
    }

    static public function addBooking($request, $order_id)
    {
        $start_date = new Carbon($request->start_date);
        $end_date = new Carbon($request->end_date);
        $all_keys = array_keys($request->all());
        $count = 0;
        foreach ($all_keys as $type_id)
        {
            $type = Hotel_room_type::find($type_id);
            if ($type)
            {
                $number = intval($request->$type_id);
                if ($number == 0) continue;
                $rooms = $type->rooms()->available($start_date, $end_date)->inRandomOrder()->limit($number)->get();
                foreach ($rooms as $room)
                {
                    for ($date = $start_date->copy(); $date->lte($end_date->copy()->addDays(-1)); $date->addDay())
                    {
                        $price = $type->price($date);

                        $item = new Order_item;
                        $item->name_en = $type->name_en;
                        $item->name_vi = $type->name_vi;
                        $item->order_id = $order_id;
                        $item->info()->associate($type);
                        $item->product()->associate($room);
                        $item->start_date = $date;
                        $item->price = $price->price;
                        $item->price_bwhere = $price->price_bwhere;
                        $item->price_direct = $price->price_direct;
                        $item->save();
                    }
                }
            }
        }
    }

    static public function boot()
    {
    	Hotel_room::bootUuid32ModelTrait();
        Hotel_room::saving(function ($room) {
        	if (Auth::user())
        	{
	            if ($room->id)
	            {
	            	$room->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$room->created_by = Auth::user()->id;
	            }
	        }
        });
        Hotel_room::deleting(function ($room) {
            foreach ($room->order_items as $item)
            {
                $item->delete();
            }
        });
    }
}
