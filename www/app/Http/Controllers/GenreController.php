<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\StoreLibraryRequest;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GenreController
{
    public function allGenresJson(Request $request): \Illuminate\Http\JsonResponse
    {
        $unique_key = Auth::user()->unique_key;
        $genres = Genre::where('library_id', $unique_key)->get();
        if($genres) {
            return response()->json(['data' => json_encode($genres)]);
        } else {
            return response()->json(['data' => null]);
        }
    }

    public function allGenres(Request $request): \Illuminate\Contracts\View\View
    {
        $unique_key = Auth::user()->unique_key;
        $genres = Genre::where('library_id', $unique_key)->get();
        return view('createGenre', compact('genres'));
    }

    public function storeGenre(StoreGenreRequest $request): \Illuminate\Http\JsonResponse
    {
        $unique_key = Auth::user()->unique_key;

        Genre::create([
            'genre' => $request->input('genre'),
            'library_id' => $unique_key
        ]);

        return response()->json(['message' => 'Вы успешно добавили жанр', 'status' => 'success'], 200);
    }

      public function deleteGenre(Request $request, $id): \Illuminate\Http\JsonResponse
      {
          $genre = Genre::find($id);

          if (!$genre) {
              return response()->json(['status' => 'error', 'message' => 'Жанр не был найден']);
          }

          $genre->delete();
          return response()->json(['status' => 'success', 'message' => 'Жанр успешно удален',]);
      }
}
