<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Hotel_room_type;
use Carbon\Carbon;
use App\Notifications\OrderCreated;
use Notification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->type == "completed")
        {
            return Order::with('status')->whereUserId(Auth::user()->id)->where("status_id", "<", 6)->get();
        }
        else
        {
            return Order::with('status')->whereUserId(Auth::user()->id)->where("status_id", ">=", 6)->get();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start_date = new Carbon($request->startDate);
        $end_date = new Carbon($request->endDate);

        $order = new Order();
        $order->fill($request->all());
        $order->fill(Auth::user()->toArray());
        $order->user_id = Auth::user()->id;
        $order->status_id = 1;
        $order->type_id = 4;
        $order->save();

        if ($request->has('ref_code'))
        {
            $user = User::whereRefCode($request->ref_code)->first();
            if ($user)
            {
                $order->discount()->associate($user);
                $order->save();
            }
        }

        $order_id = $order->id;

        foreach ($request->items as $item)
        {
            $type = Hotel_room_type::find($item['id']);
            if ($type)
            {
                $number = intval($item['numberOfBooking']);
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

                        $item->order->save();
                    }
                }
            }
        }
        $order->update_price();
        $order->save();

        Notification::send(User::withRole("admin")->get(), new OrderCreated($order));
        return ["code" => 200, "data" => $order];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
