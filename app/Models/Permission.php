<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Permission_group;
use Alsofronie\Uuid\Uuid32ModelTrait;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Auth;

class Permission extends Model
{
    use Uuid32ModelTrait, LBDatatableTrait;

	protected $fillable = array('code');
	
    public function group()
    {
        return $this->belongsTo('App\Models\Permission_group', "permission_group_id");
    }
	
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', "role_id", "permission_id", "role_permissions");
    }
	
    public function users()
    {
        return $this->belongsToMany('App\Models\User', "user_id", "permission_id", "user_permission");
    }
	
	static public function addIfNotExist($permission_name, $permission_code)
	{
		$permission_component = explode(".", $permission_code);
		$group_code = $permission_component[0];
		
		$group = Permission_group::where("code", $group_code)->first();
		if (!$group)
		{
			$group = Permission_group::addIfNotExist($group_code, $group_code);
		}
		
		$permission = Permission::firstOrNew(array("code" => $permission_code));
		if ($permission_name !== false)
		{
			$permission->name = $permission_name;
		}
		$permission->permission_group_id = $group->id;
		$permission->save();

		return $permission;
	}

    static public function boot()
    {
    	Permission::bootUuid32ModelTrait();
        Permission::saving(function ($permission) {
        	if (Auth::user())
        	{
	            if ($permission->id)
	            {
	            	$permission->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$permission->created_by = Auth::user()->id;
	            }
	        }
        });
    }
}
