<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;


class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:100',
            'permissions' => 'required|array',
            'permissions.*' => 'required',
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
            'name.required' => 'Поле "Название" обязательно для заполнения.',
            'name.min' => 'Поле "Название" должно содержать минимум :min символов.',
            'name.max' => 'Поле "Название" должно содержать максимум :max символов.',
            'permissions.required' => 'Хотя бы один ключ разрешения обязателен.',
            'permissions.*.required' => 'Каждый ключ разрешения должен содержать значение.',
        ];
    }
}
