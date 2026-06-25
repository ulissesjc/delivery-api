<?php

namespace App\DTOs\Restaurant;

use App\Http\Requests\Restaurant\UpdateRestaurantRequest;

class UpdateRestaurantDTO
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $address = null
    ) {}

    public static function fromRequest(UpdateRestaurantRequest $request): self
    {
        return new self(
            name: $request->input('name'),
            address: $request->input('address')
        );
    }
}
