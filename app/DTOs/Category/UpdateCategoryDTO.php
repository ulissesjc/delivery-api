<?php

namespace App\DTOs\Category;

use App\Http\Requests\Category\UpdateCategoryRequest;

class UpdateCategoryDTO
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $description = null
    ) {}

    public static function fromRequest(UpdateCategoryRequest $request): self
    {
        return new self(
            name: $request->input('name'),
            description: $request->input('description')
        );
    }
}
