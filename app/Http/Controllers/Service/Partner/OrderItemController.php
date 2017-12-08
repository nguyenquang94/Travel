<?php

namespace App\Http\Controllers\Service\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Hotel_room;
use App\Models\Order;
use App\Models\Order_item;
use Carbon\Carbon;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($order)
    {
        $date = new Carbon(request()->date);
        $start_date = $date->copy()->startOfMonth();
        $end_date = $date->copy()->endOfMonth();
        return Order::whereHas('items', function($query) use ($start_date, $end_date) {
            $query->where('start_date', '>=', $start_date)->where('start_date', '<=', $end_date);
        })->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($hotel_id)
    {
        $start_date = request()->start_date;
        $end_date = request()->end_date;

        $hotel = Hotel::findOrFail($hotel_id);
        $results = [];
        foreach ($hotel->roomtypes as $roomtype) {
            $result = $roomtype->toArray();
            $result["room_available"] = $roomtype->room_available($start_date, $end_date);
            $results[] = $result;
        }
        return $results;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $order_id)
    {
        Hotel_room::addBooking($request, $order_id);
        return ["code" => 200];
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
