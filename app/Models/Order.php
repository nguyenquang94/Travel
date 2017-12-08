<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;
use Carbon\Carbon;
use App\Models\Order_history;
use App\Models\Transaction;
use App\Models\Bus_provider;
use App\Models\User;

class Order extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;
    protected $fillable = ["name", "phonenumber", "email", "note", "system_balance_id", "user_id", "type_id"];
    protected $appends = ["edit_button", "delete_button", "in_action", "info_button"];

    public function getInfoButtonAttribute()
    {
        return Form::lbButton("/order/$this->id/edit", "get", "Order information", ["class" => "btn btn-xs btn-primary"])->toHtml();
    }

    public function getEditButtonAttribute()
    {
        return Form::lbButton("/order/$this->id/edit", "get", "Edit", ["class" => "btn btn-xs btn-primary"])->toHtml();
    }

    public function getDeleteButtonAttribute()
    {
        return Form::lbButton("/order/$this->id", "delete", "Delete", ["class" => "btn btn-xs btn-danger"])->toHtml();
    }

    public function creator() {
        return $this->belongsTo("App\Models\User", "created_by");
    }

    public function my_items()
    {
        return $this->hasMany("App\Models\Order_item", "order_id")->mine();
    }

    public function items()
    {
        if (!Auth::check() || Auth::user()->email == "xuanbinh91@gmail.com" || Auth::user()->email == "vpthao2102@gmail.com")
        {
            return $this->hasMany("App\Models\Order_item", "order_id");
        }
        else
        {
            return $this->my_items();
        }
    }

    public function transactions()
    {
        return $this->hasMany("App\Models\Transaction", "order_id");
    }

    public function histories()
    {
        return $this->hasMany("App\Models\Order_history", "order_id");
    }

    public function status()
    {
        return $this->belongsTo("App\Models\Order_status", "status_id");
    }

    public function payment_method()
    {
        return $this->belongsTo("App\Models\Balance", "system_balance_id");
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id");
    }

    public function discount()
    {
        return $this->morphTo();
    }

    public function scopeSuccess($query)
    {
        return $query->whereIn("status_id", [4, 5, 6]);
    }

    public function is_success()
    {
        return ($this->status_id == 4) || ($this->status_id == 5) || ($this->status_id == 6);
    }

    public function scopeOpen($query)
    {
        return $query->where("status_id", "<", 6);
    }

    public function scopeWeekly($query, $week = 0)
    {
        $start = Carbon::now()->startOfWeek()->addWeeks($week);
        $end = Carbon::now()->endOfWeek()->addWeeks($week);
        return $query->whereBetween("confirmed_at", array($start, $end));
    }

    public function scopeMonthly($query, $week = 0)
    {
        $start = Carbon::now()->startOfMonth()->addMonth($week);
        $end = Carbon::now()->endOfMonth()->addMonth($week);
        return $query->whereBetween("confirmed_at", array($start, $end));
    }

    public function getProfitAttribute()
    {
        return $this->attributes["total_price"] - $this->attributes["total_price_bwhere"];
    }

    public function getInActionAttribute()
    {
        $this->load("items", "items.info");
        $future = 0;
        foreach ($this->items as $item)
        {
            if ($item->start_date->isToday() || $item->start_date->isYesterday())
            {
                return "Active";
            }
            if ($item->start_date->isPast())
            {
                if ($future == 1)
                {
                    return "On trip";
                }
                $future = -1;
            }
            if ($item->start_date->isFuture())
            {
                if ($future == -1)
                {
                    return "On trip";
                }
                $future = 1;
            }
        }
        if ($future == 1)
        {
            return "Future";
        }
        return "Past";
    }

    public function update_status($status_id, $message)
    {
        $history = new Order_history;
        $history->status_id = $status_id;
        $history->message = $message;
        $history->order_id = $this->id;
        $history->save();
    }

    public function update_price()
    {
        $this->load("items");
        if ($this->discount)
        {
            $this->total_price = $this->items->sum("price") * 0.95;
        }
        else
        {
            $this->total_price = $this->items->sum("price");
        }
        $this->total_price_bwhere = $this->items->sum("price_bwhere");
        $this->total_price_direct = $this->items->sum("price_direct");
        $this->save();
    }

    public function create_transaction()
    {
        $system_user = User::withRole("system")->firstOrFail();
        if ($this->type_id == 2)
        {
            $array = [];
            foreach ($this->items as $item)
            {
                if ($item->info_type === "App\Models\Hotel_room_type")
                {
                    $hotel = $item->info->hotel;
                    $partner = $hotel->employee_bridges()->whereTypeId(1)->first();
                    if (!array_key_exists($partner->user_id, $array))
                    {
                        $array[$partner->user_id] = 0;
                    }
                    $array[$partner->user_id] += $item->price - $item->price_bwhere;
                }
                if ($item->info_type === "App\Models\Bus_type")
                {
                    $hotel = $item->info->provider;
                    $partner = $hotel->employee_bridges()->whereTypeId(1)->first();
                    if (!array_key_exists($partner->user_id, $array))
                    {
                        $array[$partner->user_id] = 0;
                    }
                    $array[$partner->user_id] += $item->price - $item->price_bwhere;
                }
                if ($item->info_type === "App\Models\User")
                {
                    $user = $item->info;
                    if (!array_key_exists($user->id, $array))
                    {
                        $array[$user->id] = 0;
                    }
                    $array[$user->id] += $item->price - $item->price_bwhere;
                }
            }
            foreach (array_keys($array) as $partner_id)
            {
                $partner = User::find($partner_id);
                $transaction = $partner->transfer($array[$partner_id], $system_user, "19c3867791ca4adbb24e8f27b4b549e7");
                $transaction->order()->associate($this);
                $transaction->save();
            }
        }
        else // if ($this->type_id == 1)
        {
            $transaction = $system_user->deposit($this->total_price, "146840ff9f9344d38920f0010049ea73");
            $transaction->order()->associate($this);
            $transaction->save();

            $balance = $this->payment_method;
            $transaction = $balance->deposit($this->total_price, "146840ff9f9344d38920f0010049ea73");
            $transaction->order()->associate($this);
            $transaction->save();

            // visa vnpay
            if ($this->system_balance_id == "858a41547d4e4259bc33440161c17dad")
            {
                $transaction = $system_user->deposit(- $this->total_price * 0.0275 - 2500, "0580cbb0cd3f4c50ab20ceb753faa6cb");
                $transaction->order()->associate($this);
                $transaction->save();

                $transaction = $balance->deposit(- $this->total_price * 0.0275 - 2500, "0580cbb0cd3f4c50ab20ceb753faa6cb");
                $transaction->order()->associate($this);
                $transaction->save();
            }
            else if ($this->system_balance_id == "bd006e022476425d8c77ce93296d0bfc")
            {
                $transaction = $system_user->deposit(- $this->total_price * 0.011 - 1650, "0580cbb0cd3f4c50ab20ceb753faa6cb");
                $transaction->order()->associate($this);
                $transaction->save();
                
                $transaction = $balance->deposit(- $this->total_price * 0.011 - 1650, "0580cbb0cd3f4c50ab20ceb753faa6cb");
                $transaction->order()->associate($this);
                $transaction->save();
            }

            $array = [];
            foreach ($this->items as $item)
            {
                if ($item->info_type === "App\Models\Hotel_room_type")
                {
                    $hotel = $item->info->hotel;
                    $partner = $hotel->employee_bridges()->whereTypeId(1)->first();
                    if (!array_key_exists($partner->user_id, $array))
                    {
                        $array[$partner->user_id] = 0;
                    }
                    $array[$partner->user_id] += $item->price_bwhere;
                }
                if ($item->info_type === "App\Models\Bus_type")
                {
                    $hotel = $item->info->provider;
                    $partner = $hotel->employee_bridges()->whereTypeId(1)->first();
                    if (!array_key_exists($partner->user_id, $array))
                    {
                        $array[$partner->user_id] = 0;
                    }
                    $array[$partner->user_id] += $item->price_bwhere;
                }
                if ($item->info_type === "App\Models\User")
                {
                    $user = $item->info;
                    if (!array_key_exists($user->id, $array))
                    {
                        $array[$user->id] = 0;
                    }
                    $array[$user->id] += $item->price_bwhere;
                }
            }
            foreach (array_keys($array) as $partner_id)
            {
                $partner = User::find($partner_id);
                $transaction = $system_user->transfer($array[$partner_id], $partner, "9f17cafd18d14f7fb964eada03fe7677");
                $transaction->order()->associate($this);
                $transaction->save();
            }
        }

        $ref = $this->discount;
        // add ref if not have yet.
        if ($ref)
        {
            $this->user->upline()->associate($ref);
            $this->user->save();
        }

        // add ref transaction
        if ($this->user && $this->user->upline)
        {
            $transaction = $system_user->transfer($this->items->sum("price") * 0.05, $this->user->upline, "52c6c871ece14a1d9c84e3de457d0e94");
            $transaction->order()->associate($this);
            $transaction->save();
        }
    }

    public function clear_transaction()
    {
        foreach ($this->transactions as $transaction)
        {
            $transaction->delete();
        }
    }

    public function update_transaction()
    {
        $this->update_price();
        $this->clear_transaction();
        if ($this->is_success())
        {
            $this->create_transaction();
        }
    }

    public function information()
    {
        $items = $this->items()->orderBy("start_date")->with("info", "product")->get();
        $array = [];
        foreach ($items as $item)
        {
            $found = false;
            for ($i = 0; $i < count($array); $i ++)
            {
                $element = $array[$i];
                if ($item->info_type === "App\Models\Bus_type" && $element["type"] === "bus")
                {
                    if ($item->product->trip_id == $element["item"]->product->trip_id)
                    {
                        $found = true;
                        $element["count"] += 1;
                        $element["total"] += $item->price;
                        $array[$i] = $element;
                        break;
                    }
                }
                else if ($item->info_type == "App\Models\Hotel_room_type" && $element["type"] === "room")
                {
                    if (($item->product->id == $element["item"]->product->id) && ($element["end"] == $item->start_date))
                    {
                        $found = true;
                        $element["total"] += $item->price;
                        $element["price"] += $item->price;
                        $element["end"] = (new Carbon($item->start_date))->addDay()->format("Y-m-d");
                        $array[$i] = $element;
                        break;
                    }
                }
                else if ($element["type"] === "custom")
                {
                    if (($item->name == $element["name"]) && ($element["start"] == $item->start_date) && ($element["price"] == $item->price))
                    {
                        $found = true;
                        $element["count"] += 1;
                        $element["total"] += $item->price;
                        $array[$i] = $element;
                        break;
                    }
                }
            }
            if (!$found)
            {
                if ($item->info_type === "App\Models\Bus_type")
                {
                    $array[] = [
                        "type" => "bus",
                        "name" => $item->info->name,
                        "date" => $item->product->trip->start_date." ".$item->product->trip->start_time,
                        "start" => new Carbon($item->product->trip->start_date." ".$item->product->trip->start_time),
                        "count" => 1,
                        "price" => $item->price,
                        "total" => $item->price,
                        "item" => $item
                    ];
                }
                else if ($item->info_type == "App\Models\Hotel_room_type")
                {
                    $array[] = [
                        "type" => "room",
                        "name" => $item->info->name,
                        "price" => $item->price,
                        "total" => $item->price,
                        "start" => $item->start_date,
                        "end" => (new Carbon($item->start_date))->addDay()->format("Y-m-d"),
                        "item" => $item,
                        "count" => 1
                    ];
                }
                else
                {
                    $array[] = [
                        "type" => "custom",
                        "name" => $item->name,
                        "price" => $item->price,
                        "total" => $item->price,
                        "start" => $item->start_date,
                        "item" => $item,
                        "count" => 1
                    ];
                }
            }
        }

        $result = array();
        foreach ($array as $element)
        {
            if ($element["type"] === "bus")
            {
                $result[] = $element;
            }
            else if ($element["type"] === "room")
            {
                $found = 0;
                for ($i = 0; $i < count($result); $i ++)
                {
                    $r = $result[$i];
                    if (($r["type"] == "room") && ($r["item"]->info->id == $element["item"]->info->id) && ($r["start"] == $element["start"]) && ($r["end"] == $element["end"]))
                    {
                        $found = true;
                        $r["count"] += 1;
                        $r["total"] += $element["total"];
                        $result[$i] = $r;
                        break;
                    }
                }
                if (!$found)
                {
                    $element["count"] = 1;
                    $result[] = $element;
                }
            }
            else if ($element["type"] === "custom")
            {
                $result[] = $element;
            }
        }
        return $result;
    }

    public function contact_information() {
        $items = $this->items()->orderBy("start_date")->with("info", "product")->get();
        $array = [];

        foreach ($items as $item)
        {
            if ($item->info_type == "App\Models\Bus_type")
            {
                $provider = $item->info->provider;
                $manager = $provider->employees()->wherePivot('type_id', 1)->first();
                $found = false;
                foreach ($array as $c)
                {
                    if ($c["type"] == "bus" && $c["bus"]->id == $provider->id)
                    {
                        $found = true;
                        break;
                    }
                }
                if (!$found)
                {
                    $array[] = ["type" => "bus", "bus" => $provider, "manager" => $manager];
                }
            }
            else if ($item->info_type == "App\Models\Hotel_room_type")
            {
                $hotel = $item->info->hotel;
                $manager = $hotel->employees()->wherePivot('type_id', 1)->first();
                $found = false;
                foreach ($array as $c)
                {
                    if ($c["type"] == "hotel" && $c["hotel"]->id == $hotel->id)
                    {
                        $found = true;
                        break;
                    }
                }

                if (!$found)
                {
                    $array[] = ["type" => "hotel", "hotel" => $hotel, "manager" => $manager];
                }
            }
            else if ($item->info_type == "App\Models\User")
            {
                $found = false;
                foreach ($array as $c)
                {
                    if ($c["type"] == "service" && $c["service"]->name_vi == $item->name_vi && $c["manager"]->id == $item->info->id)
                    {
                        $found = true;
                        break;
                    }
                }

                if (!$found)
                {
                    $array[] = ["type" => "service", "service" => $item, "manager" => $item->info];
                }
            }
        }
        return $array;
    }

    static public function boot()
    {
        Order::bootUuid32ModelTrait();
        Order::saving(function ($object) {
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
            $original = $object->getOriginal();
            if ((count($original) == 0 || !in_array($original["status_id"], [4, 5, 6])) && $object->is_success())
            {
                $object->confirmed_at = Carbon::now();
                $object->create_transaction();
            }
            else if (!$object->is_success())
            {
                $object->confirmed_at = null;
                $object->clear_transaction();
            }
        });

        Order::deleting(function ($object) {
            $object->items()->delete();
            $object->transactions()->delete();
            $object->histories()->delete();
        });
    }
}
