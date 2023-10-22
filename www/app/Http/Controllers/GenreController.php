<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GenreController
{
    public function showGenre(Request $request): \Illuminate\Http\JsonResponse
    {
        $unique_key = Auth::user()->unique_key;
        $genres = Genre::where('library_id', $unique_key)->get();
        if($genres) {
            return response()->json(['data' => json_encode($genres), 'status' => true]);
        } else {
            return response()->json(['data' => null, 'status' => 'Произошла ошибка']);
        }
    }

    public function storeGenre(Request $request): \Illuminate\Http\JsonResponse
    {
        $rules = [
            'genre' => 'required|max:100',
        ];
        $validator = Validator::make($request->all(), $rules);

        $unique_key = Auth::user()->unique_key;

        Genre::create([
            'genre' => $request->input('genre'),
            'library_id' => $unique_key
        ]);

        return response()->json(['message' => 'Вы успешно добавили жанр', 'status' => true], 200);
    }

      public function deleteGenre(Request $request, $id): \Illuminate\Http\JsonResponse
      {
          $genre = Genre::find($id);

          if (!$genre) {
              return response()->json(['status' => false, 'message' => 'Жанр не найден']);
          }

          $genre->delete();
          return response()->json(['status' => true, 'message' => 'Жанр успешно удален',]);
      }
}
