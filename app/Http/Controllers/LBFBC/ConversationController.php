<?php

namespace App\Http\Controllers\LBFBC;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LBFBC_conversation;
use App\Models\LBFBC_message;
use App\Models\Place;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("libressltd.lbfbc.conversation.index");
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
        $conversation = LBFBC_conversation::findOrFail($id);
        return view("libressltd.lbfbc.conversation.index", ["conversation" => $conversation]);
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
        $conversation = LBFBC_conversation::findOrFail($id);
        $user = $conversation->guest();
        switch ($request->action_type) {
            case '0':
                $hotel = Place::findOrFail($request->hotel_id);
                foreach ($hotel->media as $image)
                {
                    LBFBC_message::send_image_url($user->user_id, $image->link());
                }
                break;

            case '1':
                LBFBC_message::send_login_button($user->user_id, "Để tiếp tục, mời bạn kết nối với B-Where");
                break;

            case '2':
                if ($conversation->userBridges()->count() > 0)
                {
                    $user = User::findOrFail($conversation->userBridges()->last()->user_id);
                    dd($user);
                }
                break;
            
            default:
                # code...
                break;
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
