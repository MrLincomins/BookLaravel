<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Support\Facades\Validator;

class GenreController
{
    public function showGenre(Request $request)
    {
        $genres = Genre::all('genre');
        return view('createGenre', compact('genres'));
    }

    public function storeGenre(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $rules = [
            'genre' => 'required|max:100',
        ];

        $validator = Validator::make($request->all(), $rules);
        // JSON

        Genre::create([
            'genre' => $request->input('genre')
        ]);
        $genres = Genre::all('genre');
        return view('createGenre', compact('genres'));
    }
}
