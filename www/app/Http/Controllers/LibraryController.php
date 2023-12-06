<?php

namespace App\Http\Controllers;

use App\Models\Audit_Log;
use App\Models\Library_Application;
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
use Termwind\Components\Li;

class LibraryController extends Controller
{

    public function storeLibrary(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {

        $userid = (Auth::id());
        $unique_key = Str::random(10);
        $name = $request->get('name');

        $image = $request->file('library_img');
        if($image) {
        $imgName = 'library_img_' . $name . '.png';
            $image->move(public_path('/images/library'), $imgName);
        }


        Library::create([
            'userid' => $userid,
            'libraryName' => $name,
            'unique_key' => $unique_key,
            'organisation' => $request->get('organisation'),
            'library_img' => $imgName ?? null,
            'description' => $request->get('description'),
        ]);
    
        $user = User::find(Auth::id());
        $user->unique_key = $unique_key;
        $user->save();

        Auth::login($user);

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

        $unique_key = Auth::user()->unique_key;
        $roles = Role::where('unique_key', $unique_key)->get();

        return view('roles', compact('roles'));

    }

    public function storeRole(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $permissions = array_sum($request->input('permissions', []));

        Role::create([
            'name' => $request->input('name'),
            'permissions' => $permissions,
            'unique_key' => Auth::user()->unique_key
        ]);

        return redirect('/library/roles');
    }

    public function deleteRole(Request $request, $id): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        Role::destroy($id);
        return redirect('/library/roles');
    }

    public function assigningRole(Request $request): \Illuminate\Http\JsonResponse
    {
        $role = Role::where('id', $request->get('idRole'))->first();

        $user = User::find($request->get('idUser'));
        if ($role) {
            $user->role = $role->name;
        } else {
            $user->role = null;
        }
        $user->save();
        return response()->json(true);
    }

    public function allUsers(Request $request): \Illuminate\Contracts\View\View
    {
        $unique_key = Auth::user()->unique_key;
        $users = User::where('unique_key', $unique_key)->orderBy('class')->get();
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
            return response()->json($library);
        } else {
            return response()->json(false);
        }
    }

    public function libraryAcceptApplication(Request $request): \Illuminate\Http\JsonResponse
    {
        $unique_key = $request->input('unique_key');
        $idUser = $request->input('idUser');
        $id = $request->input('id');

        $user = User::find($idUser);
        $user->unique_key = $unique_key;
        $user->save();

        Library_Application::destroy($id);

        return response()->json(true);
    }

    public function libraryDeleteApplication(Request $request): \Illuminate\Http\JsonResponse
    {
        $id = $request->input('id');

        Library_Application::destroy($id);

        return response()->json(true);
    }

    public function libraryGetApplications(Request $request): \Illuminate\Http\JsonResponse
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

        $library = Library::where('unique_key', $unique_key)->get();

        if (!$library) {
            return false;
        }

        Library_Application::create([
            'unique_key' => $unique_key,
            'idUser' => Auth::id(),
            'nameUser' => Auth::user()->name,
        ]);

        return response()->json(true);
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

    public function allLogs(Request $request):\Illuminate\Contracts\View\View
    {
        $unique_key = Auth::user()->unique_key;
        $logs = Audit_Log::where('unique_key', $unique_key)->get();

        return view('libraryLogs', compact('logs'));
    }

}
