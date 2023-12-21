<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissions
{
    protected array $permissions = [
        'CHANGE_BOOKS' => 1,
        'DELETE_BOOKS' => 2,
        'CREATE_BOOKS' => 4,
        'ISSUE_RETURN_BOOKS' => 8,
        'MANAGE_USERS' => 16,
    ];

    public function handle($request, Closure $next, ...$permissionsToCheck)
    {
        $roleName = optional(Auth::user())->role;
        $unique_key = optional(Auth::user())->unique_key;
        $status = optional(Auth::user())->status;

        if ((int)$status !== 1) {
            if (!empty($roleName)) {
                $userPermissions = Role::where('unique_key', $unique_key)
                    ->where('name', $roleName)
                    ->value('permissions');

                $permissions = $this->permissions;

                foreach ($permissionsToCheck as $permission) {

                    $requiredPermission = $permissions[$permission];

                    if (!($userPermissions & $requiredPermission)) {
                        abort(403, 'Вход запрещён. У вас нет прав.');
                    }
                }
            } else {
                abort(403, 'Вход запрещён. У вас нет прав.');
            }
        }

        return $next($request);
    }
}
