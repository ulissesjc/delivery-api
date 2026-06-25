<?php

namespace App\Http\Requests\Order;

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
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'É necessário informar pelo menos um item',
            'items.array' => 'Os itens devem ser enviados em formato de lista',
            'items.min' => 'O pedido deve possuir ao menos um item',

            'items.*.product_id.required' => 'É necessário informar o produto',
            'items.*.product_id.integer' => 'O id do produto deve ser um valor inteiro',

            'items.*.quantity.required' => 'É necessário informar a quantidade',
            'items.*.quantity.integer' => 'A quantidade deve ser um valor inteiro',
            'items.*.quantity.min' => 'A quantidade mínima é :min',
        ];
    }
}
