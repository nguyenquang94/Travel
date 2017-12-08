<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;

class Transaction_category extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;
    protected $fillable = ["name_en", "name_vi", "parent_id"];
    protected $appends = ["name", "edit_button"];
    protected $table = "mst_transaction_categories";

    public function getEditButtonAttribute()
    {
        return Form::lbButton("/master/$this->id/edit", "get", trans("general.edit"), ["class" => "btn btn-xs btn-primary"])->toHtml();
    }

    public function getNameAttribute()
    {
        $key = "name_".\App::getLocale();
        return $this->attributes[$key];
    }

    static public function boot()
    {
    	Transaction_category::bootUuid32ModelTrait();
        Transaction_category::saving(function ($object) {
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
