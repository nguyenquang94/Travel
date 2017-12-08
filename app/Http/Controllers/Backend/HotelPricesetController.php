<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hotel_priceset;
use App\Models\Hotel_room_type;
use App\Models\Hotel;

class HotelPricesetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($hotel_id)
    {
        $hotel = Hotel::findOrFail($hotel_id);
        return view("backend.hotel.priceset.index", ["hotel" => $hotel]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $hotel_id)
    {
        $type = new Hotel_priceset;
        $type->hotel_id = $hotel_id;
        $type->fill($request->all());
        $type->save();

        return redirect("/hotel/$hotel_id/priceset/$type->id/edit");
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
        $priceset = Hotel_priceset::findOrFail($id);
        return view("backend.hotel.priceset.add", ["hotel" => $hotel, "priceset" => $priceset]);
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
        $hotel = Hotel::findOrFail($hotel_id);
        $commission = $hotel->commission;
        $priceset = Hotel_priceset::findOrFail($id);
        $priceset->fill($request->all());
        $priceset->save();

        $keys = array_keys($request->all());
        $array = array();
        foreach ($keys as $key)
        {
            if (Hotel_room_type::find($key))
            {
                $key_bwhere = $key."_bwhere";
                $key_direct = $key."_direct";

                $price = 0.0 + $request->$key;
                $price_bwhere = 0.0 + $request->$key_bwhere;
                $price_direct = 0.0 + $request->$key_direct;

                if ($price_bwhere == 0)
                {
                    $price_bwhere = $price_direct * (1 - $commission);
                }
                if ($price == 0)
                {
                    $price = $price_bwhere / (1- $commission);
                }

                $array[$key] = ["price" => $price, "price_bwhere" => $price_bwhere, "price_direct" => $price_direct];
            }
        }
        $priceset->roomtypes()->sync($array);
        return redirect()->back();
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
