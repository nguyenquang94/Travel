<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use GuzzleHttp;
use Socialite;
use App\Models\User;
use Auth;
use App\Models\LBFBC_webhook_history;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function show()
    {
        \Debugbar::disable();
        return view('backend.plist', request()->all());
    }

    public function index()
    {
        return view('home');
    }

    public function login_facebook($user_id = "" , $is_partner = "")
    {
        return Socialite::driver('facebook')->redirectUrl("http://admin.bwhere.vn/facebook/callback/$user_id")->redirect();
    }

    public function login_facebook_callback($user_id = "")
    {
        if ($user_id == "web")
        {
            $fb_user = Socialite::driver('facebook')->redirectUrl("http://admin.bwhere.vn/facebook/callback/$user_id")->user();
            $user = User::whereFacebookId($fb_user->id)->first();
            Auth::login($user, true);
            return redirect('home');
        }
        else
        {
            $fb_user = Socialite::driver('facebook')->redirectUrl("http://admin.bwhere.vn/facebook/callback/$user_id")->user();
            $user = User::whereFacebookId($fb_user->id)->first();
            if (!$user)
            {
                $user = new User;
                $user->facebook_id = $fb_user->id;
                $user->name = $fb_user->name;
                if ($fb_user->email)
                {
                    $user->email = $fb_user->email;
                }
                $user->password = bcrypt("Libreteam123");
            }
            $user->facebook_chat_id = $user_id;
            $user->save();

            $user->send_fb_message(["text" => "Xin chào $user->name. Cảm ơn bạn đã sử dụng dịch vụ của B-Where. Chúng tôi có thể giúp gì cho bạn?"]);

            return redirect("https://www.messenger.com/closeWindow/?image_url=http%3A%2F%2Fwww.freeiconspng.com%2Fuploads%2Fsuccess-icon-10.png&display_text=Completed%2C%20continue%20with%20your%20order");
        }
    }

    public function facebook()
    {
        \Debugbar::disable();
        return request()->hub_challenge;
    }

    public function postFacebook()
    {
        $request = request();
        LBFBC_webhook_history::log();

        \Debugbar::disable();
        if ($request->object == "page")
        {
            foreach ($request->entry as $entry)
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
                                $this->send($message['sender']['id'], ['text' => "Ngon roài :* :* :*"]);
                                break;
                            case 'image':
                                $this->send($message['sender']['id'], ["attachment" => ["type" => "image", "payload" => ["url" => "http://admin.bwhere.vn/lbmedia/2447b01dec4c4600816053615b266b14"]]]);
                                break;
                            case 'login':
                                $this->send_login_button($message['sender']['id']);
                                break;
                            
                            default:

                                break;
                        }
                    }
                    if (isset($message["postback"]) && isset($message["postback"]["payload"]) && $message["postback"]["payload"] == "LBFBC_GETTING_STARTED")
                    {
                        $this->send_login_button($sender_id);
                    }
                }
            }
        }
    }

    public function send_login_button($user_id)
    {
        $this->send($user_id, [
            "attachment" => [
                "type" => "template", 
                "payload" => [
                    "template_type" => "button", 
                    "text" => "Xin chào mừng bạn đến với B-Where. Chúng tôi là hệ thống đầu tiên cung cấp đầy đủ thông tin về du lịch bụi tại Việt Nam, bao gồm thông tin địa điểm du lịch, thăm thú, chỗ ăn nghỉ, xe khách, thuê xe máy, ... Hãy kết nối với B-Where ngay để trải nghiệm những dịch vụ tốt nhất.", 
                    "buttons" => [
                        [
                            "type" => "web_url",
                            "url" => "http://admin.bwhere.vn/facebook/login/$user_id",
                            "title" => "Kết nối với BWhere"
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function send($user_id, $message)
    {
        $client = new \GuzzleHttp\Client();

        $res = $client->request('POST', 'https://graph.facebook.com/v2.6/me/messages?access_token='.config("lbfbc.key"), [
            "json" => [
                'recipient' => ['id' => $user_id],
                'message' => $message,
                ],
            "headers" => [
                "Content-Type" => "application/json",
            ]
        ]);
        // echo $res->getStatusCode();
        // // "200"
        // echo $res->getHeader('content-type');
        // // 'application/json; charset=utf8'
        // echo $res->getBody();
        
    }
}
