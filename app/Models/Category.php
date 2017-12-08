<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;

class Category extends Model
{
    use LBDatatableTrait, Uuid32ModelTrait;

    protected $fillable = ["name_en", "name_vi"];
    protected $appends = ["name"];

    public function getNameAttribute()
    {
        $key = "name_".\App::getLocale();
        return $this->attributes[$key];
    }
}
