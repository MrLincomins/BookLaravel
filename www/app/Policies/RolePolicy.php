<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Role $role): bool
    {
        $userRoles = $user->roles;

        $highestUserRole = $userRoles->max('id');
        $rolePermissions = $role->permissions;

        if ($highestUserRole >= $role->id) {
            return true;
        } elseif ($rolePermissions && $rolePermissions['update']) {
            return true;
        }

        return false;
    }
}
