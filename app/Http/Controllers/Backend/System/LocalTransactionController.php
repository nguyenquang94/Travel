<?php

namespace App\Http\Controllers\Backend\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Balance;

class LocalTransactionController extends Controller
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
    public function create()
    {
        return view("backend.system.local_transaction.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $from_balance = Balance::findOrFail($request->from_id);
        $to_balance = Balance::findOrFail($request->to_id);

        $transaction = new Transaction;
        $transaction->amount = $request->amount;
        $transaction->category_id = "4a493c397e1947868e6e37ce1dc1200a";
        $transaction->type_id = 2;
        $transaction->status_id = 1;

        $transaction->from()->associate($from_balance);
        $transaction->to()->associate($to_balance);
        $transaction->save();

        if ($request->fee > 0)
        {
            $transaction = new Transaction;
            $transaction->amount = $request->fee;
            $transaction->category_id = "0580cbb0cd3f4c50ab20ceb753faa6cb";
            $transaction->type_id = 3;
            $transaction->status_id = 1;

            $transaction->from()->associate($from_balance);
            $transaction->save();
        }

        return redirect("/system/balance");
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
