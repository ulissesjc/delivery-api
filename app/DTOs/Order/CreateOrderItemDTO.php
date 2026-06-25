<?php

namespace App\DTOs\Order;

class CreateOrderItemDTO
{
    public function __construct(
        public readonly int $product_id,
        public readonly int $quantity
    ) {}
}
