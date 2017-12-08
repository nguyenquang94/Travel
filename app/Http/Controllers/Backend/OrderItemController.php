<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Hotel;
use App\Models\Hotel_room_type;
use App\Models\Hotel_room;
use Carbon\Carbon;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($order_id)
    {
        $params = [];
        if (request()->has("hotel_id"))
        {
            $params["hotel"] = Hotel::findOrFail(request()->hotel_id);
        }
        $params["order"] = Order::findOrFail($order_id);
        return view("backend.order.item.add", $params);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $order_id)
    {
        if ($request->has("type") && $request->type = "custom")
        {
            $provider = User::findOrFail($request->provider_id);
            for ($i = 0; $i < intval($request->number); $i ++)
            {
                $item = new Order_item;
                $item->fill($request->all());
                $item->order_id = $order_id;
                $item->info()->associate($provider);
                $item->save();
            }
        }
        else
        {
            Hotel_room::addBooking($request, $order_id);
        }
        return redirect("/order/$order_id/edit");
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
