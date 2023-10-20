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
 
        // Получаем разрешения текущей роли пользователя
        $rolePermissions = $role->permissions;

        // Проверяем, может ли пользователь изменить роль
        // Роль с наивысшими правами может изменить любую роль
        // Роли с меньшими правами могут изменить только роли с меньшими или равными правами
        if ($highestUserRole >= $role->id) {
            return true;
        } elseif ($rolePermissions && $rolePermissions['update']) {
            return true;
        }

        return false;
    }
}
