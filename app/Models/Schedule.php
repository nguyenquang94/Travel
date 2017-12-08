<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;

class Schedule extends Model
{
	use Uuid32ModelTrait, LBDatatableTrait;

	protected $fillable = ["name_en", "name_vi", "description_en", "description_vi", "estimated_time", "estimated_cost", "traffic_en", "traffic_vi"];
  protected $appends = ["edit_button", "points_button"];

  public function getEditButtonAttribute()
  {
    return Form::lbButton("/schedule/$this->id/edit", "get", "Edit", ["class" => "btn btn-xs btn-primary"])->toHtml();
  }

  public function getPointsButtonAttribute()
  {
    return Form::lbButton("/schedule/$this->id/point", "get", "Point", ["class" => "btn btn-xs btn-success"])->toHtml();
  }

	public function points()
	{
		return $this->hasMany("App\Models\Schedule_point", "schedule_id");
	}

	static public function boot()
	{
		Schedule::bootUuid32ModelTrait();
		Schedule::saving(function ($object) {
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
