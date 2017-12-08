<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LBFBC_conversation_user extends Model
{
    protected $table = "LBFBC_conversation_users";

    public function user()
    {
    	return $this->belongsTo("App\Models\User", "user_id", "facebook_chat_id");
    }
    public function conversation()
    {
    	return $this->belongsTo("App\Models\LBFBC_conversation", "conversation_id");
    }

    static public function boot()
    {
        LBFBC_conversation_user::creating(function ($cu) {
			if ($cu->user_id != config("lbfbc.page_id"))
			{            
		        $client = new \GuzzleHttp\Client();

		        $res = $client->request('GET', "https://graph.facebook.com/v2.6/$cu->user_id?access_token=".config("lbfbc.key"));
		        $result = json_decode($res->getBody());
		        $cu->user_firstname = $result->first_name;
		        $cu->user_lastname = $result->last_name;
		        $cu->avatar = $result->profile_pic;
		    }
		    else
		    {
		    	$cu->user_firstname = "BWhere";
		    }
        });
    }
}
