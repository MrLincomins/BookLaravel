<?php

namespace App\Http\Controllers;

use App\Models\Role_Permission;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createPermission(): \Illuminate\Contracts\View\View
    {
        $permissions = Role_Permission::all();
        return view('createPermissions', compact('permissions'));

    }

}
