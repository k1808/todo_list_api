<?php

namespace App\Traits;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRolesAndPermissions
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }


    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        foreach ($this->permissions() as $per){
            if($per->slug ===$permission){
                return true;
            }
        }
        return false;
    }

}
