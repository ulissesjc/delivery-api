<?php

namespace App\DTOs\Product;

use App\Http\Requests\Product\StoreProductRequest;

class CreateProductDTO
{
    public function __construct(
        public readonly int $category_id,
        public readonly string $name,
        public readonly float $price,
        public readonly ?string $description = null,
        public readonly ?bool $is_available = true
    ) {}

    public static function fromRequest(StoreProductRequest $request): self
    {
        return new self(
            category_id: (int) $request->route('category'),
            name: $request->string('name'),
            price: $request->float('price'),
            description: $request->input('description'),
            is_available: $request->boolean('is_available', true)
        );
    }
}
