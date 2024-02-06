<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;


class StoreGenreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'genre' => 'required|min:2|max:100'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new ValidationException($validator, $this->jsonResponse($validator));
    }

    protected function jsonResponse($validator): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors()->first(),
        ]);
    }

    public function messages(): array
    {
        return [
            'genre.required' => 'Поле "Жанр" является обязательным.',
            'genre.max' => 'Поле "Жанр" не может превышать :max символов.',
            'genre.min' => 'Поле "Жанр" должно содержать минимум :min символа.',
        ];
    }
}
