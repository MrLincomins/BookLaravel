<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;


class StoreLibraryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:5|max:100',
            'description' => 'required|max:500',
            'organisation' => 'required|min:2|max:250'
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
            'name.required' => 'Поле "Название" является обязательным.',
            'name.min' => 'Поле "Название" должно содержать минимум :min символов.',
            'name.max' => 'Поле "Название" не должно превышать :max символов.',
            'description.required' => 'Поле "Описание" является обязательным.',
            'description.max' => 'Поле "Описание" не должно превышать :max символов.',
            'organisation.required' => 'Поле "Организация" является обязательным.',
            'organisation.min' => 'Поле "Организация" должно содержать минимум :min символа.',
            'organisation.max' => 'Поле "Организация" не должно превышать :max символов.',
        ];
    }
}
