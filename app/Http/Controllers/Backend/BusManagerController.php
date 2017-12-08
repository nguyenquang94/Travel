<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bus_provider;
use App\Models\Bus_manager;
use App\Models\User;

class BusManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bus_id)
    {
        $bus = Bus_provider::findOrFail($bus_id);
        return view("backend.bus.manager.index", ["bus" => $bus]);
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
        $user = User::findOrFail($request->user_id);
        $bus->employees()->syncWithoutDetaching([$user->id => ["type_id" => 2]]);
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
    public function update(Request $request, $bus_id, $id)
    {
        $managers = Bus_manager::whereBusProviderId($bus_id)->get();
        foreach ($managers as $manager)
        {
            if ($manager->id == $id)
            {
                $manager->type_id = 1;
            }
            else
            {
                $manager->type_id = 2;
            }
            $manager->save();
        }
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
