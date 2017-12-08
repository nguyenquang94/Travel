<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;

class Order_history extends Model
{
    
    use Uuid32ModelTrait, LBDatatableTrait;

    protected $fillable = ["status_id", "message"];

    public function order()
    {
        return $this->belongsTo("App\Models\Order", "order_id");
    }

    public function status()
    {
        return $this->belongsTo("App\Models\Order_status", "status_id");
    }

    static public function boot()
    {
    	Order_history::bootUuid32ModelTrait();
        Order_history::saving(function ($object) {
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
            $object->order->status_id = $object->status_id;
            $object->order->save();
        });
    }
}
