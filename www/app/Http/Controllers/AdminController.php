<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Library;

class AdminController extends Controller
{

    public function globalSettings(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
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
