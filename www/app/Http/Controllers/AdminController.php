<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Library;
use Illuminate\Support\Str;

class AdminController extends Controller
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
    
}
