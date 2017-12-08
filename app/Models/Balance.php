<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;

use App\Models\Transaction;

class Balance extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;
    protected $fillable = ["user_id", "bank_id", "bank_number", "bank_holder_name", "bank_branch"];
    protected $appends = ["edit_button", "system_transaction_button"];

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
        $this->amount = $this->in_transactions()->success()->sum("amount") - $this->out_transactions()->success()->sum("amount");
    }

    public function getEditButtonAttribute()
    {
        return Form::lbButton("/master/$this->id/edit", "get", trans("general.edit"), ["class" => "btn btn-xs btn-primary"])->toHtml();
    }

    public function getSystemTransactionButtonAttribute()
    {
        return Form::lbButton("/system/balance/$this->id/transaction", "get", "Transaction", ["class" => "btn btn-xs btn-success"])->toHtml();
    }

    public function getNameAttribute()
    {
        $key = "name_".\App::getLocale();
        return $this->attributes[$key];
    }

    public function getBriefInformationAttribute()
    {
        return $this->bank->shortname." - ".number_format($this->amount);
    }

    public function bank()
    {
        return $this->belongsTo("App\Models\Bank", "bank_id");
    }

    public function type()
    {
        return $this->belongsTo("App\Models\Balance_type", "type_id");
    }

    public function in_transactions()
    {
        return $this->morphMany('App\Models\Transaction', 'to');
    }

    public function out_transactions()
    {
        return $this->morphMany('App\Models\Transaction', 'from');
    }

    public function scopeSystem($query)
    {
        return $query->whereTypeId(1);
    }

    public function scopeVirtual($query)
    {
        return $query->whereTypeId(2);
    }

    public function scopePrimary($query)
    {
        return $query->whereTypeId(3);
    }

    public function scopeSecondary($query)
    {
        return $query->whereTypeId(3);
    }

    static public function boot()
    {
    	Balance::bootUuid32ModelTrait();
        Balance::saving(function ($object) {
        	if (Auth::user())
        	{
	            if ($object->id)
	            {
	            	$object->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$object->created_by = Auth::user()->id;
	            }
	        }
        });
    }
}
