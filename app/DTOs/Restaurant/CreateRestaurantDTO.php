<?php

namespace App\DTOs\Restaurant;

use App\Http\Requests\Restaurant\StoreRestaurantRequest;

class CreateRestaurantDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $address
    ) {}

    public static function fromRequest(StoreRestaurantRequest $request): self
    {
        return new self(
            name: $request->string('name'),
            address: $request->string('address')
        );
    }
}
