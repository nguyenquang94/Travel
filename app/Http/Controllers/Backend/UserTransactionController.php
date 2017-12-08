<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Transaction;
use App\Models\User;

class UserTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $user = User::findOrFail($user_id);
        return view("backend.user.transaction.index", ["user" => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id)
    {
        $user = User::findOrFail($user_id);
        return view("backend.user.transaction.add", ["user" => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $from_balance = Balance::findOrFail($request->from_id);

        $transaction = new Transaction;
        $transaction->amount = $request->amount;
        $transaction->category_id = "717dc99bafe04d559cb673203a8a3dae";
        $transaction->type_id = 3;
        $transaction->status_id = 1;

        $transaction->from()->associate($user);
        $transaction->save();

        $transaction = new Transaction;
        $transaction->amount = $request->amount;
        $transaction->category_id = "717dc99bafe04d559cb673203a8a3dae";
        $transaction->type_id = 3;
        $transaction->status_id = 1;

        $transaction->from()->associate($from_balance);
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

        return redirect("/user");
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
