<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'min:3', 'max:255'],
            'description' => ['sometimes', 'string', 'min:5', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'O nome deve ser um texto válido',
            'name.min' => 'O nome deve ter no mínimo :min caracteres',
            'name.max' => 'O nome deve ter no máximo :max caracteres',

            'description.string' => 'A descrição deve ser um texto válido',
            'description.min' => 'A descrição deve ter no mínimo :min caracteres',
            'description.max' => 'A descrição deve ter no máximo :max caracteres',
        ];
    }
}
