<?php

namespace App\Http\Controllers;
use App\Models\Books;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController
{
    public function showGenre(Request $request)
    {
        $genres = Genre::all('genre');
        return view('createGenre', compact('genres'));
    }

    public function storeGenre(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        Genre::create([
            'genre' => $request->input('genre')
        ]);
        $genres = Genre::all('genre');
        return view('createGenre', compact('genres'));
    }
}
