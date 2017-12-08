<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;
use Form;

class Place extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;
    protected $fillable = [
        "name_en", "name_vi", 
        "name_in_url_en", "name_in_url_vi", 
        "description_en", "description_vi", 
        "short_description_en", "short_description_vi", 
        "address_en", "address_vi",
        "enable_en", "enable_vi",
        "latitude", "longitude", "zoom",
        "category_id",
    ];
    protected $appends = ["ok_en", "ok_vi"];

    public function children()
    {
        return $this->hasMany("App\Models\Place", "parent_id");
    }

    public function parent()
    {
        return $this->belongsTo("App\Models\Place", "parent_id");
    }

    public function category()
    {
        return $this->belongsTo("App\Models\MstPlaceCategory", "category_id");
    }

    public function media()
    {
        return $this->belongsToMany("App\Models\Media", "place_media", "place_id", "media_id");
    }

    public function hotels()
    {
        if (Auth::user() && (Auth::user()->email == "vpthao2102@gmail.com" || Auth::user()->email == "xuanbinh91@gmail.com"))
        {
            return $this->belongsToMany("App\Models\Hotel", "place_hotels", "place_id", "hotel_id");
        }
        else
        {
            return $this->belongsToMany("App\Models\Hotel", "place_hotels", "place_id", "hotel_id")->where("enable_vi", 1);
        }
    }

    public function all_hotels()
    {
        if (Auth::user() && (Auth::user()->email == "vpthao2102@gmail.com" || Auth::user()->email == "xuanbinh91@gmail.com"))
        {
            return $this->belongsToMany("App\Models\Hotel", "place_hotels", "place_id", "hotel_id");
        }
        else
        {
            return $this->belongsToMany("App\Models\Hotel", "place_hotels", "place_id", "hotel_id")->where("enable_vi", 1);
        }
    }

    public function info()
    {
        return $this->morphTo();
    }

    public function getOkEnAttribute()
    {
        if ($this->description_en == null || strlen($this->description_en) == 0)
        {
            return "<a class='btn btn-xs btn-danger' href='/place/$this->id/edit'>Missing description</a>";
        }
        if ($this->media_count == 0)
        {
            return "<a class='btn btn-xs btn-danger' href='/place/$this->id/image'>Missing image</a>";
        }
        if ($this->image_id == null)
        {
            return "<a class='btn btn-xs btn-danger' href='/place/$this->id/image'>Missing avatar</a>";
        }
        if ($this->latitude == null || $this->longitude == null)
        {
            return "<a class='btn btn-xs btn-danger' href='/place/$this->id/location'>Missing location</a>";
        }
        if (!$this->enable_en)
        {
            return "<a class='btn btn-xs btn-warning' href='/place/$this->id?enable_en=1'>Should enable</a>";
        }
        return "<span class='label label-success'>Enabled</span>";
    }

    public function getOkViAttribute()
    {
        if ($this->description_vi == null || strlen($this->description_vi) == 0)
        {
            return "<a class='btn btn-xs btn-danger' href='/place/$this->id/edit'>Missing description</a>";
        }
        if ($this->media_count == 0)
        {
            return "<a class='btn btn-xs btn-danger' href='/place/$this->id/image'>Missing image</a>";
        }
        if ($this->image_id == null)
        {
            return "<a class='btn btn-xs btn-danger' href='/place/$this->id/image'>Missing avatar</a>";
        }
        if ($this->latitude == null || $this->longitude == null)
        {
            return "<a class='btn btn-xs btn-danger' href='/place/$this->id/location'>Missing location</a>";
        }
        if (!$this->enable_vi)
        {
            return "<a class='btn btn-xs btn-warning' href='/place/$this->id?enable_vi=1'>Should enable</a>";
        }
        return "<span class='label label-success'>Enabled</span>";
    }

    public function getNameAttribute()
    {
        $key = "name_".\App::getLocale();
        return $this->attributes[$key];
    }

    static function resort($parent_id)
    {
        $places = Place::whereParentId($parent_id)->orderBy('name_vi')->get();
        if ($parent_id)
        {
            $parent = Place::find($parent_id);
            $index = 1;
            foreach ($places as $place)
            {
                $place->code = $parent->code.".".sprintf("%02d", $index);
                $place->save();
                $index ++;
                Parent::resort($place->id);
            }
        }
        else
        {
            $index = 1;
            foreach ($places as $place)
            {
                $place->code = sprintf("%02d", $index);
                $place->save();
                $index ++;
                Parent::resort($place->id);
            }
        }
    }

    static public function boot()
    {
    	Place::bootUuid32ModelTrait();
        Place::saving(function ($place) {
        	if (Auth::user())
        	{
	            if ($place->id)
	            {
	            	$place->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$place->created_by = Auth::user()->id;
	            }
	        }
            if ($place->parent_id)
            {
                $parent = Place::find($place->parent_id);
                if ($parent)
                {
                    $place->level = $parent->level + 1;
                }
            }
        });
    }
}
