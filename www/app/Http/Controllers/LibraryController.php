<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Library;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;

class LibraryController extends Controller
{

    public function storeLibrary(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {

        $userid = (Auth::id());
        $username = (Auth::user())->name;

        $unique_key = Str::random(10); // случайный ключ из 10 символов

        // создание записи о данной библиотеке
        Library::create([
            'userid' => $userid,
            'username' => $username,
            'unique_key' => $unique_key,
        ]);

        // Добавление ключа пользователю
        $user = User::find(Auth::id());
        $user->unique_key = $unique_key;
        $user->save();

        Auth::login($user);

        return redirect('/books');
    }


    public function libraryEntrance(Request $request): bool|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    {
        $unique_key = $request->input('unique_key');

        $library = Library::where('unique_key', $unique_key)->first();

        if (!$library) {
            return false;
        }

        $user = User::find(Auth::id());
        $user->unique_key = $unique_key;
        $user->save();

        return redirect('/books');
    }

    public function globalSettings(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $name = $request->get('nameLibrary');
        $image = $request->file('image');
        $info = $request->get('info');

        $imageName = 'image' . Library::count() + 1 . '.' . $image->getClientOriginalExtension();

        $destinationPath = '/resources/images/library';
        $image->move(public_path($destinationPath), $imageName);

        Library::create([
            'name' => $name,
            'image' => $imageName,
            'info' => $info,
        ]);

        return redirect('/books');
    }

    public function createRole(Request $request): \Illuminate\Contracts\View\View
    {
        $libraryId = Auth::user()->unique_key;
        $roles = Role::where('unique_key', $libraryId)->get();

        return view('roles', compact('roles'));

    }
    // Переписать систему ролей как у линукса
    public function storeRole(Request $request)
    {
        $permissions = 0;
        foreach ($request->input('permissions', []) as $permission) {
            $permissions |= (int) $permission;
        }

        Role::create([
            'name' => $request->input('name'),
            'permissions' => $permissions,
            'unique_key' => Auth::user()->unique_key
        ]);

        return redirect('/library/roles');
    }

    public function allUsers(Request $request): \Illuminate\Contracts\View\View
    {
        $libraryId = Auth::user()->unique_key;
        $users = User::where('unique_key', $libraryId)->orderBy('class')->get();
        return view('userManagement', compact('users'));
    }

    public function kickUser(Request $request, $id): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $user = User::find($id);
        $user->unique_key = null;
        $user->save();
        return redirect('/library/users');
    }

}
