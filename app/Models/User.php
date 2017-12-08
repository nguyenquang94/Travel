<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Alsofronie\Uuid\Uuid32ModelTrait;
use LIBRESSLtd\DeepPermission\Traits\DPUserModelTrait;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Laravel\Passport\HasApiTokens;

use App\Models\Balance;
use Form;
use Hash;

class User extends Authenticatable
{
    use Notifiable, Uuid32ModelTrait, DPUserModelTrait, LBDatatableTrait, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'phonenumber',
    ];

    protected $appends = ['transaction_button', 'edit_button'];

    protected $with = [ "roles" ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function send_fb_message($message)
    {
        $client = new \GuzzleHttp\Client();

        $res = $client->request('POST', 'https://graph.facebook.com/v2.6/me/messages?access_token='.config("lbfbc.key"), [
            "json" => [
                'recipient' => ['id' => $this->facebook_chat_id],
                'message' => $message,
                ],
            "headers" => [
                "Content-Type" => "application/json",
            ]
        ]);
    }

    public function getTransactionButtonAttribute()
    {
        return Form::lbButton("/user/$this->id/transaction", "get", "Transaction", ["class" => "btn btn-xs btn-success"])->toHtml();
    }

    public function getEditButtonAttribute()
    {
        return Form::lbButton("/user/$this->id/edit", "get", "Edit", ["class" => "btn btn-xs btn-primary"])->toHtml();
    }

    public function deposit($amount, $category_id)
    {
        $transaction = new Transaction;
        $transaction->type_id = 1;
        $transaction->status_id = 1;
        $transaction->amount = $amount;
        $transaction->to()->associate($this);
        $transaction->category_id = $category_id;
        $transaction->save();

        return $transaction;
    }

    public function withdrawal($amount, $category_id)
    {
        $transaction = new Transaction;
        $transaction->type_id = 3;
        $transaction->status_id = 1;
        $transaction->amount = $amount;
        $transaction->from()->associate($this);
        $transaction->category_id = $category_id;
        $transaction->save();

        return $transaction;
    }

    public function transfer($amount, $to_balance, $category_id)
    {
        $transaction = new Transaction;
        $transaction->type_id = 2;
        $transaction->status_id = 1;
        $transaction->amount = $amount;
        $transaction->from()->associate($this);
        $transaction->to()->associate($to_balance);
        $transaction->category_id = $category_id;
        $transaction->save();

        return $transaction;
    }

    public function calculate_amount()
    {
        $this->balance = $this->in_transactions()->success()->sum("amount") - $this->out_transactions()->success()->sum("amount");
    }

    protected function balances()
    {
        return $this->hasMany("App\Models\Balance", "user_id");
    }

    public function in_transactions()
    {
        return $this->morphMany('App\Models\Transaction', 'to');
    }

    public function out_transactions()
    {
        return $this->morphMany('App\Models\Transaction', 'from');
    }

    protected function virtual_balance()
    {
        return $this->hasMany("App\Models\Balance", "user_id")->virtual();
    }

    protected function primary_balance()
    {
        return $this->hasMany("App\Models\Balance", "user_id")->primary();
    }

    protected function secondary_balance()
    {
        return $this->hasMany("App\Models\Balance", "user_id")->secondary();
    }

    public function lbfbc_user()
    {
        return $this->belongsTo("App\Models\LBFBC_conversation_user", "facebook_chat_id", "user_id");
    }

    public function hotels()
    {
        return $this->belongsToMany("App\Models\Hotel", "hotel_managers", "user_id", "hotel_id");
    }

    public function devices()
    {
        return $this->belongsToMany("App\Models\Device", "user_devices", "user_id", "device_id");
    }

    public function upline()
    {
        return $this->belongsTo("App\Models\User", "upline_id");
    }

    public function downlines()
    {
        return $this->hasMany("App\Models\User", "upline_id");
    }

    public function promoted_orders()
    {
        return $this->morphMany('App\Models\Order', 'discount');
    }

    public static function findForPassport($username)
    {
        if (strpos($username, "fb_bwhere_") === 0)
        {
            $facebook_id = substr($username, 10);
            $user = User::whereFacebookId($facebook_id)->first();
            if ($user)
            {
                $user->loginType = "facebook";
                return $user;
            }
            else
            {
                $user = new User();
                $user->facebook_id = $facebook_id;
                $user->save();

                $user->loginType = "facebook";
                return $user;
            }
        }
        else
        {
            return User::where("username", $username)->orWhere("email", $username)->first();
        }
    }

    public function validateForPassportPasswordGrant($password)
    {
        if ($this->loginType == "facebook")
        {
            return true;
        }
        else
        {
            if (Hash::check($password, $this->password))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}
