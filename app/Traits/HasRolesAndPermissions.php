<?php
namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;

trait HasRolesAndPermissions
{
    /**
     * @param mixed ...$roles
     * @return bool
     */
    public function hasRole($roles)
    {
        $rolesRel = $this->roles->toArray();
        foreach ($rolesRel as $roleRel) {
            foreach ($roles as $role) {
                // dd($roleRel['slug'], $role);
                if ($roleRel['slug'] == $role) {
                    return true;
                }
            }

        }

        return false;
    }
    public function isAdmin()
    {
        foreach ($this->roles as $role) {
            if ($role->slug == 'admin') {
                return true;
            }

        }
        return false;
    }
    public function isSender()
    {
        foreach ($this->roles as $role) {
            if ($role->slug == 'sender') {
                return true;
            }

        }
        return false;
    }
    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return (bool) $this->permissions->where('slug', $permission)->count();
    }
    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }
    /**
     * @param array $permissions
     * @return mixed
     */
    public function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug', $permissions)->get();
    }
    /**
     * @param mixed ...$permissions
     * @return $this
     */
    public function deletePermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

/**
 * @param mixed ...$permissions
 * @return HasRolesAndPermissions
 */
    public function refreshPermissions(...$permissions)
    {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }
/**
 * @param mixed ...$permissions
 * @return $this
 */
    public function givePermissionsTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if ($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }
/**
 * @param $permission
 * @return bool
 */
    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission->slug);
    }
    /**
     * @return mixed
     */
    public function roles()
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
}
