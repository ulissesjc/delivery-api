<?php

namespace App\DTOs;

use App\Http\Requests\StoreCategoryRequest;

class CreateCategoryDTO
{
    public function __construct(
        public readonly int $restaurant_id,
        public readonly string $name,
        public readonly ?string $description = null
    ) {}

    public static function fromRequest(StoreCategoryRequest $request): self
    {
        return new self(
            restaurant_id: (int) $request->route('restaurant'),
            name: $request->string('name'),
            description: $request->input('description')
        );
    }
}
