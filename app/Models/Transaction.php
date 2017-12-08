<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;

class Transaction extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;
    protected $appends = ["delete_button"];

    public function getDeleteButtonAttribute()
    {
        return Form::lbButton("/transaction/$this->id", "delete", trans("general.delete"), ["class" => "btn btn-xs btn-danger"])->toHtml();
    }

    public function type()
    {
        return $this->belongsTo("App\Models\Transaction_type", "type_id");
    }

    public function category()
    {
        return $this->belongsTo("App\Models\Transaction_category", "category_id");
    }

    public function order()
    {
        return $this->belongsTo("App\Models\Order", "order_id");
    }
    
    public function from()
    {
        return $this->morphTo();
    }
    
    public function to()
    {
        return $this->morphTo();
    }

    public function scopeSuccess($query)
    {
        return $query->whereStatusId(1);
    }

    static public function boot()
    {
    	Transaction::bootUuid32ModelTrait();
        Transaction::saving(function ($object) {
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

                if ($object->from)
                {
                    $from = $object->from;
                    $from->calculate_amount();
                    $from->save();
                }

                if ($object->to)
                {
                    $to = $object->to;
                    $to->calculate_amount();
                    $to->save();
                }
	        }
        });

        Transaction::saved(function ($object) {
            if ($object->from)
            {
                $from = $object->from;
                $from->calculate_amount();
                $from->save();
            }

            if ($object->to)
            {
                $to = $object->to;
                $to->calculate_amount();
                $to->save();
            }
        });
        Transaction::deleted(function ($object){
            if ($object->from)
            {
                $from = $object->from;
                $from->calculate_amount();
                $from->save();
            }

            if ($object->to)
            {
                $to = $object->to;
                $to->calculate_amount();
                $to->save();
            }
        });
    }
}
