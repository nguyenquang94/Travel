<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\Uuid32ModelTrait;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Auth;

class Role extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;

	protected $fillable = array('code');
    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', "role_permissions", "role_id", "permission_id");
    }
	
    public function users()
    {
        return $this->belongsToMany('App\Models\User', "user_roles", "role_id", "user_id");
    }
	
	static public function addIfNotExist($role_name, $role_code)
	{
		$group = Role::firstOrNew(array("code" => $role_code));
		if ($role_name !== false)
		{
			$group->name = $role_name;
		}
		$group->save();
		return $group;
	}

    static public function boot()
    {
    	Role::bootUuid32ModelTrait();
        Role::saving(function ($role) {
        	if (Auth::user())
        	{
	            if ($role->id)
	            {
	            	$role->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$role->created_by = Auth::user()->id;
	            }
	        }
        });
    }
}
