<?php

namespace App\DTOs;

use App\Http\Requests\UpdateCategoryRequest;

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
