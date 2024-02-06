<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape(['tittle' => "string", 'author' => "string", 'year' => "string", 'isbn' => "string", 'genre' => "string", 'count' => "string"])]
    public function rules(): array
    {
        return [
            'tittle' => 'required|max:200',
            'author' => 'required|min:4|max:200',
            'year' => 'required|numeric|digits:4',
            'isbn' => 'required|numeric|digits_between:10,13',
            'genre' => 'required|min:2|max:100',
            'count' => 'required|numeric'
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
            'tittle.required' => 'Поле "Заголовок" является обязательным.',
            'tittle.max' => 'Поле "Заголовок" не может превышать :max символов.',
            'author.required' => 'Поле "Автор" является обязательным.',
            'author.min' => 'Поле "Автор" должно содержать минимум :min символа.',
            'author.max' => 'Поле "Автор" не может превышать :max символов.',
            'year.required' => 'Поле "Год" является обязательным.',
            'year.numeric' => 'Поле "Год" должно быть числовым.',
            'year.max' => 'Поле "Год" не может превышать :max символов.',
            'isbn.required' => 'Поле "ISBN" является обязательным.',
            'isbn.numeric' => 'Поле "ISBN" должно быть числовым.',
            'isbn.digits_between' => 'ISBN должен быть от :min до :max символов в длину.',
            'genre.required' => 'Поле "Жанр" является обязательным.',
            'genre.min' => 'Поле "Жанр" должно содержать минимум :min символа.',
            'genre.max' => 'Поле "Жанр" не может превышать :max символов.',
            'count.required' => 'Поле "Число книг" является обязательным.',
            'count.numeric' => 'Поле "Число книг" должно быть числовым.',
        ];
    }
}

