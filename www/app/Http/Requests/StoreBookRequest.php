<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;


class StoreBookRequest extends FormRequest
{
    public function authorise(): bool
    {
        return true;
    }

    #[ArrayShape(['tittle' => "string", 'author' => "string", 'year' => "string", 'isbn' => "string", 'genre' => "string"])]
    public function rules(): array
    {
        return [
            'tittle' => 'required|max:200',
            'author' => 'required|max:200',
            'year' => 'required|numeric',
            'isbn' => 'required|max:13',
            'genre' => 'required',
        ];
    }
}
