<?php

namespace App\Http\Controllers\LBFBC;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LBFBC_webhook_history;
use App\Models\LBFBC_message;

class WebhookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        \Debugbar::disable();
        LBFBC_webhook_history::log();
        if ($request->has("hub_mode") && $request->hub_mode == "subscribe")
        {
            if ($request->has("hub_verify_token") && $request->hub_verify_token == config("lbfbc.key"))
            {
                return $request->hub_challenge;
            }
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
        \Debugbar::disable();
        LBFBC_webhook_history::log();

        $params = request()->all();
        if ($params["object"] == "page")
        {
            foreach ($request["entry"] as $entry)
            {
                foreach ($entry['messaging'] as $message)
                {
                    if ($message["sender"]["id"] == config("lbfbc.page_id")) continue;
                    
                    $sender_id = $message['sender']['id'];
                    if (isset($message["message"]) && isset($message["message"]["text"]))
                    {
                        switch ($message["message"]["text"])
                        {
                            case 'check':
                                LBFBC_message::send_text($message['sender']['id'], "Ngon roài :* :* :*");
                                break;
                            case 'image':
                                LBFBC_message::send_image_url($message['sender']['id'], "http://admin.bwhere.vn/lbmedia/2447b01dec4c4600816053615b266b14");
                                break;
                            case 'login':
                                LBFBC_message::send_login_button($message['sender']['id']);
                                break;
                            
                            default:

                                break;
                        }
                    }
                    if (isset($message["postback"]) && isset($message["postback"]["payload"]) && $message["postback"]["payload"] == "LBFBC_GETTING_STARTED")
                    {
                        LBFBC_message::send_login_button($sender_id);
                    }
                }
            }
        }
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
