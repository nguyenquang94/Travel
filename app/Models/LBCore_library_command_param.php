<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\Uuid32ModelTrait;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;

class LBCore_library_command_param extends Model
{
	use Uuid32ModelTrait, LBDatatableTrait;
    protected $table = "LBCore_library_command_params";
    protected $fillable = ["param", "value"];

    public function command()
    {
    	return $this->belongsTo("App\Models\LBCore_library_command", "command_id");
    }
}
