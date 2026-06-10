<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:5', 'max:100'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max: 30', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'O nome deve ser um texto válido',
            'name.min' => 'O nome deve ter no mínimo :min caracteres',
            'name.max' => 'O nome deve ter no máximo :max caracteres',

            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'É necessário informar um e-mail válido',
            'email.unique' => 'E-mail indisponível',

            'password.required' => 'A senha é obrigatória',
            'password.string' => 'A senha deve ser um texto válido',
            'password.min' => 'A senha deve ter no mínimo :min caracteres',
            'password.max' => 'A senha deve ter no máximo :max caracteres',
        ];
    }
}
