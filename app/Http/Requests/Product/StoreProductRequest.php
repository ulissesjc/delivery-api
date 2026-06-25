<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'price' => ['required', 'numeric', 'gt:0'],
            'description' => ['sometimes', 'string', 'min:5', 'max:255'],
            'is_available' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'O nome deve ser um texto válido',
            'name.min' => 'O nome deve ter no mínimo :min caracteres',
            'name.max' => 'O nome deve ter no máximo :max caracteres',

            'price.required' => 'O preço é obrigatório',
            'price.numeric' => 'O preço deve ser um valor numérico',
            'price.gt' => 'O preço deve ser maior que 0',

            'description.string' => 'A descrição deve ser um texto válido',
            'description.min' => 'A descrição deve ter no mínimo :min caracteres',
            'description.max' => 'A descrição deve ter no máximo :max caracteres',

            'is_available.boolean' => 'A disponibilidade deve ser verdadeira ou falsa',
        ];
    }
}
