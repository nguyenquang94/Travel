<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;

class Order_item extends Model
{
    use LBDatatableTrait, Uuid32ModelTrait;

    protected $fillable = ["name_en", "name_vi", "price", "price_bwhere", "price_direct", "start_date"];
    protected $dates = ["start_date"];

    public function order()
    {
    	return $this->belongsTo("App\Models\Order", "order_id");
    }

    public function info()
    {
        return $this->morphTo();
    }

    public function product()
    {
        return $this->morphTo();
    }

    public function room_type()
    {
        return $this->belongsTo("App\Models\Hotel_room_type", "info_id");
    }

    public function bus_type()
    {
        return $this->belongsTo("App\Models\Bus_type", "info_id");
    }

    public function scopeMine($query)
    {
        return $query->where(function($query) {
            $query->whereHas("room_type", function($query_room_type) {
                $query_room_type->whereHas("hotel", function($query_hotel) {
                    $query_hotel->whereHas("employees", function($query_employees) {
                        $query_employees->where("users.id", Auth::user()->id);
                    });
                });
            })->orWhereHas("bus_type", function($query_bus_type) {
                $query_bus_type->whereHas("provider", function($bus_provider) {
                    $bus_provider->whereHas("employees", function($query_employees2) {
                        $query_employees2->where("users.id", Auth::user()->id);
                    });
                });
            });
        });
    }

    public function scopeActive($query)
    {
        return $query->whereHas("order", function($query1) {
            $query1->where("status_id", "<", 7);
        });
    }

    public function getNameAttribute()
    {
        $key = "name_".\App::getLocale();
        return $this->attributes[$key];
    }

    static public function boot()
    {
        Order_item::bootUuid32ModelTrait();
        Order_item::saving(function ($object) {
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

        Order_item::saved(function ($object) {
            $order = $object->order;
            $order->update_price();
        });
    }
}
