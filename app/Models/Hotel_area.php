<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;

class Hotel_area extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;

    protected $fillable = ["name_en", "name_vi"];
    protected $appends = ["delete_button"];

    public function getDeleteButtonAttribute()
    {
        if ($this->rooms->count() == 0)
        {
            return Form::lbButton("/hotel/".$this->hotel->id."/area/$this->id", "delete", trans("general.delete"), ["class" => "btn btn-xs btn-danger"])->toHtml();
        }
        else
        {
            return $this->rooms->count()." rooms";
        }
    }

    public function rooms()
    {
        return $this->hasMany("App\Models\Hotel_room", "area_id");
    }

    public function hotel()
    {
        return $this->belongsTo("App\Models\Hotel", "hotel_id");
    }

    static public function boot()
    {
    	Hotel_area::bootUuid32ModelTrait();
        Hotel_area::saving(function ($area) {
        	if (Auth::user())
        	{
	            if ($area->id)
	            {
	            	$area->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$area->created_by = Auth::user()->id;
	            }
	        }
        });
    }
}
