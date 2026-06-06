<?php

namespace App\DTOs;

use App\Http\Requests\StoreOrderRequest;

class CreateOrderDTO
{
    public function __construct(
        public readonly int $restaurant_id,
        public readonly array $items,
    ) {}

    public static function fromRequest(StoreOrderRequest $request): self
    {
        return new self(
            restaurant_id: (int) $request->route('restaurant'),
            items: array_map(
                fn ($item) => new CreateOrderItemDTO(
                    product_id: $item['product_id'],
                    quantity: $item['quantity'],
                ),
                $request->input('items')
            ),
        );
    }
}
