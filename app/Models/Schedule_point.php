<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;

class Schedule_point extends Model
{
	use Uuid32ModelTrait, LBDatatableTrait;

	protected $fillable = ["description_en", "description_vi", "estimated_time", "estimated_cost", "estimated_day", "estimated_distance"];
  protected $appends = ["edit_button"];

  public function getEditButtonAttribute()
  {
    return Form::lbButton("/schedule/$this->schedule_id/point/$this->id/edit", "get", "Edit", ["class" => "btn btn-xs btn-primary"])->toHtml();
  }

	public function schedule()
	{
		return $this->belongsTo("App\Models\Schedule", "schedule_id");
	}

	public function places()
	{
		return $this->belongsToMany("App\Models\Place", "schedule_point_places", "schedule_point_id", "place_id");
	}

	static public function boot()
	{
		Schedule_point::bootUuid32ModelTrait();
		Schedule_point::saving(function ($object) {
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
