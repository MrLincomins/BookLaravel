<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PermissionService
{
    protected function getUserPermissions(): int
    {
        $roleName = optional(Auth::user())->role;
        $unique_key = optional(Auth::user())->unique_key;

        if (!empty($roleName)) {
            return Role::where('unique_key', $unique_key)
                ->where('name', $roleName)
                ->value('permissions');
        }
        return 0;
    }

    public function hasPermission($permission): bool
    {
        if($this->checkLibrarian()){
            return true;
        }

        $roleName = @Auth::user()->role;
        $userPermissions = $this->getUserPermissions();

        if (!empty($roleName) && !empty($permission)) {
            $rolePermissions = Role::where('name', $roleName)
                ->value('permissions');

            if ($rolePermissions & $userPermissions & $permission) {
                return true;
            }
        }
        return false;
    }

    public function checkLibrarian(): bool
    {
        $userId = Auth::id();
        $status = (User::find($userId))->status;
        if($status == 1){
            return true;
        }
        return false;

    }
}
