<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;

class Transaction_type extends Model
{
	use LBDatatableTrait;
    protected $fillable = ["name_en", "name_vi"];
    protected $appends = ["name"];
    protected $table = "mst_transaction_types";

    public function getNameAttribute()
    {
        $key = "name_".\App::getLocale();
        return $this->attributes[$key];
    }
}
