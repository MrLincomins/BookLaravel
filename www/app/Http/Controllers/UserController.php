<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'class' => $request->input('class'),
            'status' => $request->input('status'),
            'password' => Hash::make($request->input('password'))
        ]);

        Auth::login($user);

        return redirect('/books');

    }

//    public function login(Request $request)
//    {
//
//    }

}
