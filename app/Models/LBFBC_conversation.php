<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use App\Models\LBFBC_conversation_user;

class LBFBC_conversation extends Model
{
    protected $table = "LBFBC_conversations";
    use LBDatatableTrait, Uuid32ModelTrait;

    public function user_bridges()
    {
        return $this->hasMany("App\Models\LBFBC_conversation_user", "conversation_id");
    }

    public function messages()
    {
        return $this->hasMany("App\Models\LBFBC_message", "conversation_id")->orderBy("created_at");
    }

    public function addUser($user_id)
    {
    	$user = $this->user_bridges()->whereUserId($user_id)->first();
    	if (!$user)
    	{
    		$user = new LBFBC_conversation_user;
    		$user->conversation_id = $this->id;
    		$user->user_id = $user_id;
    		$user->save();
    	}
    }

    public function guest()
    {
        foreach ($this->user_bridges as $u)
        {
            if ($u->user_id != config("lbfbc.page_id"))
            {
                return $u;
            }
        }
        return false;
    }
}
