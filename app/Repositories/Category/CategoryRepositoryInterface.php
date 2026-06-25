<?php

namespace App\Repositories\Category;

use App\DTOs\Category\CreateCategoryDTO;
use App\DTOs\Category\UpdateCategoryDTO;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function getAll(string $restaurantId, int $perPage): LengthAwarePaginator;

    public function findOne(string $id): Category;

    public function new(CreateCategoryDTO $dto): Category;

    public function update(string $id, UpdateCategoryDTO $dto): Category;

    public function delete(string $id): void;

    public function findByNameInRestaurant(string $name, int $restaurantId): ?Category;
}
