<?php

namespace App\Http\Controllers;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\NotificationsService;


class UserController extends Controller
{
    public function register(RegisterUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::create([
            'name' => $request->input('name'),
            'class' => $request->input('class'),
            'status' => $request->input('status'),
            'password' => Hash::make($request->input('password'))
        ]);

        (new NotificationsService())->createNotification(
            $user->id,
            'Sys',
            'Приветствие',
            'Добро пожаловать в библиотеку! Пройдите по ссылке чтобы посмотреть инструкцию пользования! '
        );

        Auth::login($user);
        if($request->input('status') == 1){
            return response()->json(['redirect' => '/library']);
        } else {
            return response()->json(['redirect' => '/']);
        }
    }


    public function logout(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        return redirect('/');
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        if(Auth::attempt(['name' =>  $request->input('name'),
            'password' => $request->input('password'),
            ]))
        {
            return response()->json(['redirect' => '/']);
        } else {
            return response()->json(['message' => 'Логин или пароль не верен', 'status' => 'error']);
        }
    }

    public function account(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::where('id', Auth::id())->first();

        return view('account', compact('user'));
    }

    public function notificationsGet(Request $request): \Illuminate\Contracts\View\View
    {
        $notifications = Notification::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();

        return view('notifications', compact('notifications'));
    }

    public function notificationsDelete(Request $request, $id): bool
    {
        Notification::destroy($id);
        return true;
    }

    public function notificationTest(Request $request)
    {
        Notification::create([
            'user_id' => Auth::id(),
            'event_name' => $request->input('event_name'),
            'message' => $request->input('message'),
            'read' => false
        ]);

        return redirect('/notificationstest');
    }
}
