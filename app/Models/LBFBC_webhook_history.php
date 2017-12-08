<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use App\Models\LBFBC_message;

class LBFBC_webhook_history extends Model
{
    protected $table = "LBFBC_webhook_histories";
    use LBDatatableTrait, Uuid32ModelTrait;

    static function log()
    {
    	$history = new LBFBC_webhook_history;
    	$history->content = json_encode(request()->all());
    	$history->save();

    	$params = request()->all();
    	if (isset($params["object"]) && $params["object"] == "page")
    	{
    		if (isset($params["entry"]))
    		{
    			foreach ($params["entry"] as $entry)
    			{
    				if (isset($entry["messaging"]))
    				{
    					foreach ($entry["messaging"] as $messaging)
    					{
    						if (isset($messaging["message"]) && isset($messaging["message"]["text"]))
    						{
    							$message = new LBFBC_message;
    							$message->sender_id = $messaging["sender"]["id"];
    							$message->receiver_id = $messaging["recipient"]["id"];
    							$message->message = $messaging["message"]["text"];
    							$message->mid = $messaging["message"]["mid"];
    							$message->save();
    						}
    					}
    				}
    			}
    		}
    	}
    }
}
