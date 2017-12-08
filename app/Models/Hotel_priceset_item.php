<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;

class Hotel_priceset_item extends Model
{
    use LBDatatableTrait;

    protected $fillable = ["start_date", "priceset_id"];
}
