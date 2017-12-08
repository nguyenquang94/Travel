<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Schedule_point;

class SchedulePointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($schedule_id)
    {
        $schedule = Schedule::findOrFail($schedule_id);
        return view("backend.schedule.point.index", ["schedule" => $schedule]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($schedule_id)
    {
        $schedule = Schedule::findOrFail($schedule_id);
        return view("backend.schedule.point.add", ["schedule" => $schedule]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $schedule_id)
    {
        $schedule = Schedule::findOrFail($schedule_id);
        $point = new Schedule_point;
        $point->fill($request->all());
        $point->schedule_id = $schedule->id;
        $point->save();

        if ($request->place_ids)
        {
            $point->places()->sync($request->place_ids);
        }
        else if ($request->has("place_ids"))
        {
            $point->places()->sync([]);
        }

        return redirect(url("/schedule/$schedule_id/point"));
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
    public function edit($schedule_id, $id)
    {
        $schedule = Schedule::findOrFail($schedule_id);
        $point = Schedule_point::findOrFail($id);
        return view("backend.schedule.point.add", ["schedule" => $schedule, "point" => $point]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $schedule_id, $id)
    {
        $schedule = Schedule::findOrFail($schedule_id);
        $point = Schedule_point::findOrFail($id);
        $point->fill($request->all());
        $point->schedule_id = $schedule->id;
        $point->save();

        if ($request->place_ids)
        {
            $point->places()->sync($request->place_ids);
        }
        else if ($request->has("place_ids"))
        {
            $point->places()->sync([]);
        }

        return redirect(url("/schedule/$schedule_id/point"));
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
