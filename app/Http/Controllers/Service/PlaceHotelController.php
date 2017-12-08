<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Place;
use Carbon\Carbon;

class PlaceHotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $start_date = request()->start_date;
        $end_date = request()->end_date;

        if ($id == "all")
        {
            return Place::has("hotels")->withCount(["all_hotels", "hotels" => function($query) use ($start_date, $end_date) {
                $query->available($start_date, $end_date);
            }])->get();
        }
        else
        {
            $begin = new Carbon($start_date);
            $end = new Carbon($end_date);
            
            $place = Place::findOrFail($id);
            return $place->hotels()->available($start_date, $end_date)->with(
                "active_priceset_weekdays", 
                "active_priceset_weekdays.monday_priceset.items", 
                "active_priceset_weekdays.tuesday_priceset.items", 
                "active_priceset_weekdays.wednesday_priceset.items", 
                "active_priceset_weekdays.thursday_priceset.items", 
                "active_priceset_weekdays.friday_priceset.items", 
                "active_priceset_weekdays.saturday_priceset.items", 
                "active_priceset_weekdays.sunday_priceset.items")
            ->withCount(["rooms" => function ($query) use ($begin, $end) {
                $query->available($begin, $end);
            }])->get();
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
        //
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
