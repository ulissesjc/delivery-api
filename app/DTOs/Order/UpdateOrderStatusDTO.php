<?php

namespace App\DTOs\Order;

use App\Enums\OrderStatus;
use App\Http\Requests\Order\UpdateOrderStatusRequest;

class UpdateOrderStatusDTO
{
    public function __construct(
        public readonly OrderStatus $status
    ) {}

    public static function fromRequest(UpdateOrderStatusRequest $request): self
    {
        return new self(
            status: OrderStatus::from($request->string('status'))
        );
    }
}
