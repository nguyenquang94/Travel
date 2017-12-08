<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;

class Order_status extends Model
{
	use LBDatatableTrait;
    protected $fillable = ["name_en", "name_vi"];
    protected $appends = ["name"];
    protected $table = "mst_order_statuses";

    public function getNameAttribute()
    {
        $key = "name_".\App::getLocale();
        return $this->attributes[$key];
    }
}
