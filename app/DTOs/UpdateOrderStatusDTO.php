<?php

namespace App\DTOs;

use App\Enums\OrderStatus;
use App\Http\Requests\UpdateOrderStatus;

class UpdateOrderStatusDTO
{
    public function __construct(
        public readonly OrderStatus $status
    ) {}

    public static function fromRequest(UpdateOrderStatus $request): self
    {
        return new self(
            status: OrderStatus::from($request->string('status'))
        );
    }
}
