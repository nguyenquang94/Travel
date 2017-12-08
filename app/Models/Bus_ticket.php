<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use App\Models\Bus_trip;
use App\Models\Order_item;
use Auth;
use Form;

class Bus_ticket extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;
    protected $fillable = ["price", "price_bwhere", "price_direct"];
    protected $appends = ["edit_button", "status"];

    public function getEditButtonAttribute()
    {
        return Form::lbButton("/bus/$this->provider_id/priceset/$this->id/edit", "get", "Edit", ["class" => "btn btn-xs btn-primary"])->toHtml();
    }

    public function trip()
    {
        return $this->belongsTo("App\Models\Bus_trip", "trip_id");
    }

    public function order_items()
    {
        return $this->morphMany('App\Models\Order_item', 'product');
    }

    public function scopeAvailable($query)
    {
        return $query->has("order_items", "<", 1);
    }

    public function scopeSold($query)
    {
        return $query->has("order_items", ">", 0);
    }

    public function getStatusAttribute()
    {
        if ($this->order_items->count() == 0)
        {
            return "Available";
        }
        else
        {
            return "Sold";
        }
    }

    static public function addBooking($request, $order_id) {

        $all_keys = array_keys($request->all());
        $count = 0;
        foreach ($all_keys as $trip_id)
        {
            $trip = Bus_trip::find($trip_id);
            if ($trip)
            {
                $number = intval($request->$trip_id);
                if ($number == 0) continue;

                $tickets = $trip->tickets()->with("trip", "trip.type", "trip.priceset")->available()->limit($number)->get();
                foreach ($tickets as $ticket)
                {
                    $item = new Order_item;
                    $item->name_en = $ticket->trip->type->name_en;
                    $item->name_vi = $ticket->trip->type->name_vi;
                    $item->order_id = $order_id;
                    $item->info()->associate($ticket->trip->type);
                    $item->product()->associate($ticket);
                    $item->start_date = $ticket->trip->start_date;
                    $item->price = $ticket->trip->priceset->price;
                    $item->price_bwhere = $ticket->trip->priceset->price_bwhere;
                    $item->price_direct = $ticket->trip->priceset->price_direct;
                    $item->save();
                }
            }
        }
    }

    static public function boot()
    {
    	Bus_ticket::bootUuid32ModelTrait();
        Bus_ticket::saving(function ($object) {
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
