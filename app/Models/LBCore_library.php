<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\Uuid32ModelTrait;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use App\Models\LBCore_library_command;
use App\Models\LBCore_library_command_param;
use Form;

class LBCore_library extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;
    protected $table = "LBCore_libraries";
    protected $fillable = ["code"];
    protected $appends = ["command_buttons"];

    public function getCommandButtonsAttribute()
    {
        $html = "";
        foreach ($this->commands as $c)
        {
            $html .= Form::lbButton("/lbcore/library/$this->id/command/$c->id", "GET", $c->command, ["class" => "btn btn-primary"])->toHtml(). " ";
        }
        return $html;
    }

    public static function import($object)
    {
    	$library = LBCore_library::firstOrNew(["code" => $object["code"]]);
    	$library->save();

    	foreach ($object["commands"] as $command_info)
    	{
    		$command = LBCore_library_command::whereCommand($command_info["command"])->whereLibraryId($library->id)->first();
            if (!$command)
            {
                $command = new LBCore_library_command();
            }
            $command->command = $command_info["command"];
            $command->library()->associate($library);
    		$command->save();

    		$params = $command_info["params"];
    		foreach (array_keys($params) as $param_key)
    		{
    			$param = LBCore_library_command_param::whereParam($param_key)->whereCommandId($command->id)->first();
                if (!$param)
                {
                    $param = new LBCore_library_command_param;
                }
                $param->param = $param_key;
    			$param->value = $params[$param_key];
                $param->command()->associate($command);
    			$param->save();
    		}
    	}
    }

    public function commands()
    {
        return $this->hasMany("App\Models\LBCore_library_command", "library_id");
    }
}
