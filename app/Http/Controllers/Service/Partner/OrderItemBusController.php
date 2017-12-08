<?php

namespace App\Http\Controllers\Service\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bus_trip;
use App\Models\Bus_provider;
use App\Models\Bus_ticket;

class OrderItemBusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bus_provider_id)
    {
        $start_date = request()->start_date;
        $end_date = request()->end_date;

        $bus_provider = Bus_provider::findOrFail($bus_provider_id);
        $results = [];
        foreach ($bus_provider->trips()->where("start_date", ">=", $start_date)->where("start_date", "<=", $end_date)->with("type", "priceset")->get() as $trip) {
            $result = $trip->toArray();
            $result["ticket_available"] = $trip->ticket_available();
            $results[] = $result;
        }
        return $results;
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
    public function store(Request $request, $order_id)
    {
        Bus_ticket::addBooking($request, $order_id);
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
