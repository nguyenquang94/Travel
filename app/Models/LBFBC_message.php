<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use App\Models\LBFBC_conversation_user;

class LBFBC_message extends Model
{
    protected $table = "LBFBC_messages";
    use LBDatatableTrait, Uuid32ModelTrait;

    public function sender()
    {
        return $this->belongsTo("App\Models\LBFBC_conversation_user", "sender_id", "user_id");
    }

    public function receiver()
    {
        return $this->belongsTo("App\Models\LBFBC_conversation_user", "receiver_id", "user_id");
    }

    public static function send_login_button($user_id, $message = null)
    {
        if (!$message)
        {
            $message = "Xin chào mừng bạn đến với B-Where. Chúng tôi là hệ thống đầu tiên cung cấp đầy đủ thông tin về du lịch bụi tại Việt Nam, bao gồm thông tin địa điểm du lịch, thăm thú, chỗ ăn nghỉ, xe khách, thuê xe máy, ... Hãy kết nối với B-Where ngay để trải nghiệm những dịch vụ tốt nhất.";
        }
        LBFBC_message::send($user_id, [
            "attachment" => [
                "type" => "template", 
                "payload" => [
                    "template_type" => "button", 
                    "text" => $message, 
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

    public static function send_text($user_id, $message)
    {
        LBFBC_message::send($user_id, ["text" => $message]);
    }

    public static function send_image_url($user_id, $url)
    {
        LBFBC_message::send($user_id, [
            "attachment" => [
                "type" => "image",
                "payload" => [
                    "url" => $url
                ]
            ]
        ]);
    }

    public static function send($user_id, $message)
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
    }

    public function findConversation()
    {
        $user_id = $this->sender_id;
        if ($user_id == config("lbfbc.page_id"))
        {
            $user_id = $this->receiver_id;
        }
        $cu = LBFBC_conversation_user::whereUserId($user_id)->first();
        $conversation;
        if ($cu)
        {
            $conversation = LBFBC_conversation::findOrFail($cu->conversation_id);
        }
        else
        {
            $conversation = new LBFBC_conversation;
            $conversation->save();
        }
        $conversation->touch();
        $this->conversation_id = $conversation->id;
        return $conversation;
    }

    static public function boot()
    {
        LBFBC_message::bootUuid32ModelTrait();
        LBFBC_message::saving(function ($message) {
            $conversation = $message->findConversation();
            $conversation->addUser($message->sender_id);
            $conversation->addUser($message->receiver_id);
        });
    }
}
