<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bus_provider;
use App\Models\Bus_trip;
use App\Models\Bus_priceset;
use App\Models\Bus_ticket;

class BusTripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bus_id)
    {
        $bus = Bus_provider::findOrFail($bus_id);
        return view("backend.bus.trip.index", ["bus" => $bus]);
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
    public function store(Request $request, $bus_id)
    {
        $bus = Bus_provider::findOrFail($bus_id);
        $trip = new Bus_trip;
        $trip->fill($request->all());
        $trip->provider_id = $bus->id;
        $trip->save();

        $priceset = Bus_priceset::findOrFail($request->priceset_id);

        for ($i = 0; $i < $request->num_ticket; $i ++)
        {
            $ticket = new Bus_ticket;
            $ticket->fill($priceset->toArray());
            $ticket->trip_id = $trip->id;
            $ticket->save();
        }

        return redirect()->back();
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
