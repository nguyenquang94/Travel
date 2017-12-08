<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Permission;

class Role_permission extends Model
{
    public function role()
    {
        return $this->belongsTo('App\Models\Role', "role_id");
    }

    public function permission()
    {
        return $this->belongsTo('App\Models\Permission', "permission_id");
    }
	
	static public function addIfNotExist($role_code, $permission_code)
	{
        $role = Role::where("code", $role_code)->first();
        if (!$role)
        {
            $role = Role::addIfNotExist($role_code, $role_code);
        }

        $permission = Permission::where("code", $permission_code)->first();
        if (!$permission)
        {
            $permission = Permission::addIfNotExist($permission_code, $permission_code);
        }

        $rp = Role_permission::where("role_id", $role->id)->where("permission_id", $permission->id)->first();
        if (!$rp)
        {
            $rp = new Role_permission;
            $rp->role_id = $role->id;
            $rp->permission_id = $permission->id;
            $rp->save();
        }
        return $rp;
	}
}
