<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\Uuid32ModelTrait;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;

class LBCore_library_command extends Model
{
	use Uuid32ModelTrait, LBDatatableTrait;
    protected $table = "LBCore_library_commands";
    protected $fillable = ["command"];

    public function library()
    {
    	return $this->belongsTo("App\Models\LBCore_library", "library_id");
    }

    public function params()
    {
    	return $this->hasMany("App\Models\LBCore_library_command_param", "command_id");
    }
}
