<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Auth;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with("roles", "permissions", "roles.permissions")->findOrFail(Auth::user()->id);
        if ($user->hasRole("partner") && strlen($user->ref_code) == 0)
        {
            $random = str_random(8);
            while (true)
            {
                if (User::whereRefCode($random)->count() == 0)
                {
                    $user->ref_code = $random;
                    $user->save();
                    break;
                }
                $random = str_random(8);
            }
        }
        return $user;
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
    public function store(UserRequest $request)
    {
        $user = new User;
        $user->fill($request->all());
        $user->save();

        return ["code" => 200, "data" => $user];
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
        if ($id == "me")
        {
            $user = Auth::user();
            $user->fill($request->all());

            if ($request->has('password') && $request->has('old_password'))
            {
                if (Hash::check($request->old_password, $user->password))
                {
                    $user->password = Hash::make($request->password);
                }
                else
                {
                    return ["code" => "900", "description" => "Password not correct"];
                }
            }
            $user->save();
            return ["code" => 200, "data" => $user];
        }
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
