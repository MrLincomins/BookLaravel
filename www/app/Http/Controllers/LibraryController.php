<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLibraryRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Models\Audit_Log;
use App\Models\Books;
use App\Models\Library_Application;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Library;
use Illuminate\Support\Str;

class LibraryController extends Controller
{

    public function storeLibrary(StoreLibraryRequest $request): \Illuminate\Http\JsonResponse
    {
        $userid = (Auth::id());
        $unique_key = Str::random(10);

        Library::create([
            'userid' => $userid,
            'libraryName' => $request->get('name'),
            'unique_key' => $unique_key,
            'organisation' => $request->get('organisation'),
            'description' => $request->get('description'),
        ]);

        $user = User::find(Auth::id());
        $user->unique_key = $unique_key;
        $user->save();

        Auth::login($user);

        return response()->json(['redirect' => '/books']);
    }

    public function createRole(Request $request): \Illuminate\Contracts\View\View
    {

        $unique_key = Auth::user()->unique_key;
        $roles = Role::where('unique_key', $unique_key)->get();

        return view('roles', compact('roles'));
    }

    public function getRolesJson(Request $request): \Illuminate\Http\JsonResponse
    {
        $unique_key = Auth::user()->unique_key;
        $roles = Role::where('unique_key', $unique_key)->get();
        return response()->json(['data' => json_encode($roles)]);
    }

    public function storeRole(StoreRoleRequest $request): \Illuminate\Http\JsonResponse
    {
        $permissions = array_sum($request->input('permissions', []));


        Role::create([
            'name' => $request->input('name'),
            'permissions' => $permissions,
            'unique_key' => Auth::user()->unique_key
        ]);

        return response()->json(['message' => 'Роль успешно создана', 'status' => 'success']);
    }

    public function deleteRole(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['status' => 'error', 'message' => 'Роль не найдена']);
        }

        Role::destroy($id);
        return response()->json(['status' => 'success', 'message' => 'Роль успешно удалена']);
    }

    public function assigningRole(Request $request): \Illuminate\Http\JsonResponse
    {
        $role = Role::where('id', $request->get('idRole'))->first();

        $user = User::find($request->get('idUser'));
        if($user) {
            if ($role) {
                $user->role = $role->name;
            } else {
                $user->role = null;
            }
            $user->save();
        } else {
            return response()->json(['status' => 'error', 'message' => 'Пользователь не был найден']);
        }
        return response()->json(['status' => 'success', 'message' => 'Роль пользователя успешно изменена']);
    }

    public function allUsers(Request $request): \Illuminate\Contracts\View\View
    {
        $unique_key = Auth::user()->unique_key;
        $users = User::where('unique_key', $unique_key)->orderBy('class')->with('userBooks')->get();
        $roles = Role::where('unique_key', $unique_key)->get();
        return view('userManagement', compact('users', 'roles'));
    }

    public function kickUser(Request $request, $id): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $user = User::find($id);
        $user->unique_key = null;
        $user->save();
        return redirect('/library/users');
    }

    public function libraryGet(Request $request): \Illuminate\Http\JsonResponse
    {
        $unique_key = $request->get('unique_key');

        $library = Library::where('unique_key', $unique_key)->first();
        if ($library) {
            return response()->json(['message' => 'Библиотека успешно найдена', 'status' => 'success', 'library' => $library]);
        } else {
            return response()->json(['message' => 'Библиотека не найдена', 'status' => 'error']);
        }
    }

    public function libraryAcceptApplication(Request $request): \Illuminate\Http\JsonResponse
    {
        $unique_key = $request->input('unique_key');
        $idUser = $request->input('idUser');
        $id = $request->input('id');

        $user = User::find($idUser);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Данного пользователя не существует']);
        }

        $user = User::find($idUser);
        $user->unique_key = $unique_key;
        $user->save();

        $application = Library_Application::find($id);
        if (!$application) {
            return response()->json(['status' => 'error', 'message' => 'Заявка не найдена']);
        }

        $application->delete();

        return response()->json(['status' => 'success', 'message' => 'Заявка успешно принята']);
    }

    public function libraryDeleteApplication(Request $request): \Illuminate\Http\JsonResponse
    {
        $id = $request->input('id');
        $application = Library_Application::find($id);
        if (!$application) {
            return response()->json(['status' => 'error', 'message' => 'Заявка не найдена']);
        }
        $application->delete();

        return response()->json(['status' => 'success', 'message' => 'Заявка успешно отклонена']);
    }

    public function libraryGetApplications(Request $request): \Illuminate\Contracts\View\View
    {
        $unique_key = Auth::user()->unique_key;

        $applications = Library_Application::where('unique_key', $unique_key)->get();

        $users = [];
        foreach ($applications as $application) {
            $users[] = User::find($application->idUser);
        }
        return view('acceptApplications', compact('applications', 'users'));

    }

    public function libraryGetApplicationsJson(Request $request): \Illuminate\Http\JsonResponse
    {
        $unique_key = Auth::user()->unique_key;

        $applications = Library_Application::where('unique_key', $unique_key)->get();

        $users = [];
        foreach ($applications as $application) {
            $users[] = User::find($application->idUser);
        }
        return response()->json(['applications' => $applications, 'users' => $users]);
    }

    public function libraryApplication(Request $request): bool|\Illuminate\Http\JsonResponse
    {
        $unique_key = $request->input('code');

        if(Library_Application::where('unique_key', $unique_key)->where('idUser', Auth::id())->exists()){
            return response()->json(['message' => 'Вы уже отправляли заявку в данную библиотеку!', 'status' => 'error']);
        }

        $library = Library::where('unique_key', $unique_key)->get();

        if (!$library) {
            return response()->json(['message' => 'Ошибка при отправке заявки!', 'status' => 'error']);
        }

        Library_Application::create([
            'unique_key' => $unique_key,
            'idUser' => Auth::id(),
            'nameUser' => Auth::user()->name,
        ]);



        return response()->json(['message' => 'Заявка успешно отправлена', 'status' => 'success']);
    }

    public function deleteLibrary(Request $request): \Illuminate\Http\JsonResponse
    {
        $unique_key = $request->get('unique_key');

        $library = Library::where('unique_key', $unique_key)->first();

        if (Library::destroy($library->id)) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function allLogs(Request $request): \Illuminate\Contracts\View\View
    {
        $unique_key = Auth::user()->unique_key;
        $logs = Audit_Log::where('unique_key', $unique_key)->get();

        return view('libraryLogs', compact('logs'));
    }

    public function exitLibrary(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $user = User::find(Auth::id());
        $user->unique_key = null;
        $user->save();
        return redirect('/');
    }

}
