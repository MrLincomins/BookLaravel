<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function register(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
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

    public function logout(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        return redirect('/books');
    }

    public function login(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if(Auth::attempt(['name' =>  $request->input('name'),
            'password' => $request->input('password'),
            'class' => $request->input('class')]))
        {
            return redirect('/books');
        } else {
            return redirect()->back();
        }
    }

}
