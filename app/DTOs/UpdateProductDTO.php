<?php

namespace App\DTOs;

use App\Http\Requests\UpdateProductRequest;

class UpdateProductDTO
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?float $price = null,
        public readonly ?string $description = null,
    ) {}

    public static function fromRequest(UpdateProductRequest $request): self
    {
        return new self(
            name: $request->input('name'),
            price: $request->input('price'),
            description: $request->input('description')
        );
    }
}
