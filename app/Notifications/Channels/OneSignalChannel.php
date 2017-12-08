<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;

class OneSignalChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toOneSignal($notifiable);

        $fields = array(
            'app_id' => "11bbdb72-5b63-4bc0-aa73-e6d1670db06f",
            'include_player_ids' => $notifiable->devices->pluck("token")->all(),
            'data' => array("foo" => "bar"),
            'large_icon' =>"ic_launcher_round.png",
            'contents' => ["en" => $message["content"]],
            'headings' => ["en" => $message["heading"]]
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic YTc1ZDY5ZWYtN2Y5OS00ZTY3LTk5MDMtZDA4NzM4MzU1ZGJk'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

        $response = curl_exec($ch);
        curl_close($ch);
    }
}