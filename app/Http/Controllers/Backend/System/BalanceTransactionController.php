<?php

namespace App\Http\Controllers\Backend\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Transaction;
use App\Models\User;

class BalanceTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($balance_id)
    {
        $balance = Balance::findOrFail($balance_id);
        return view("backend.system.balance.transaction.index", ["balance" => $balance]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($balance_id)
    {
        $balance = Balance::findOrFail($balance_id);
        return view("backend.system.balance.transaction.add", ["balance" => $balance]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $balance_id)
    {
        $balance = Balance::findOrFail($balance_id);
        $balance->deposit($request->amount, $request->category_id);
        $system_user = User::withRole("system")->first();
        $system_user->deposit($request->amount, $request->category_id);

        return redirect(url("system/balance"));
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
