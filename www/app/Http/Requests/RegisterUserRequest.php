<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;


class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape(['name' => "string", 'class' => "string", 'status' => "string", 'password' => "string"])]
    public function rules(): array
    {
        return [
            'name' => 'required|min:5|max:200',
            'class' => 'nullable|min:2|max:4',
            'status' => 'required|numeric',
            'password' => 'required|min:5|max:50',
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
            'name.min' => 'Имя пользователя должно содержать минимум 5 символов.',
            'name.required' => 'Имя пользователя обязательно для заполнения.',
            'name.max' => 'Имя пользователя не должно превышать 200 символов.',
            'class.min' => 'Класс должен содержать минимум 2 символа.',
            'class.max' => 'Класс не должен превышать 4 символов.',
            'status.required' => 'Статус пользователя обязателен для заполнения.',
            'status.numeric' => 'Статус пользователя должен быть числом.',
            'password.required' => 'Пароль обязателен для заполнения.',
            'password.min' => 'Пароль должен содержать минимум 5 символов.',
            'password.max' => 'Пароль не должен превышать 50 символов.',
        ];
    }
}

