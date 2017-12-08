<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Hotel_room_type;

class HotelRoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($hotel_id)
    {
        $hotel = Hotel::findOrFail($hotel_id);
        return view("backend.hotel.roomtype.index", ["hotel" => $hotel]);
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
    public function store(Request $request, $hotel_id)
    {
        $type = new Hotel_room_type;
        $type->hotel_id = $hotel_id;
        $type->fill($request->all());
        $type->save();

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
    public function edit($hotel_id, $id)
    {
        $hotel = Hotel::findOrFail($hotel_id);
        $roomtype = Hotel_room_type::findOrFail($id);
        return view("backend.hotel.roomtype.add", ["hotel" => $hotel, "room_type" => $roomtype]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $hotel_id, $id)
    {
        $type = Hotel_room_type::findOrFail($id);
        $type->hotel_id = $hotel_id;
        $type->fill($request->all());
        $type->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($hotel_id, $id)
    {
        $type = Hotel_room_type::findOrFail($id);
        $type->delete();

        return redirect()->back();
    }
}
