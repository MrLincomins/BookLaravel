<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function register(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $rules = [
            'name' => 'required',
            'class' => 'required|max:4',
            'status' => 'required|numeric',
            'password' => 'required|max:40',
        ];

        $validator = Validator::make($request->all(), $rules);
        // JSON

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
        return redirect('/');
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

    public function account(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::where('id', Auth::id())->first();

        return view('account', compact('user'));

    }

}
