<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'restaurant_id' => ['required', 'integer', 'exists:restaurants,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'restaurant_id.required' => 'É necessário informar o restaurante',
            'restaurant_id.integer' => 'O id do restaurante deve ser um valor inteiro',
            'restaurant_id.exists' => 'O restaurante informado não existe',

            'items.required' => 'É necessário informar pelo menos um item',
            'items.array' => 'Os itens devem ser enviados em formato de lista',
            'items.min' => 'O pedido deve possuir ao menos um item',

            'items.*.product_id.required' => 'É necessário informar o produto',
            'items.*.product_id.integer' => 'O id do produto deve ser um valor inteiro',
            'items.*.product_id.exists' => 'O produto informado não existe',

            'items.*.quantity.required' => 'É necessário informar a quantidade',
            'items.*.quantity.integer' => 'A quantidade deve ser um valor inteiro',
            'items.*.quantity.min' => 'A quantidade mínima é :min',
        ];
    }
}
