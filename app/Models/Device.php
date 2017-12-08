<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\Uuid32ModelTrait;

class Device extends Model
{
    use Uuid32ModelTrait;

    protected $fillable = ["token", "type"];

    public function users()
    {
        return $this->belongsToMany("App\Models\Device", "user_devices", "device_id", "user_id");
    }
}
