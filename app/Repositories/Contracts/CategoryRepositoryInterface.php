<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateCategoryDTO;
use App\DTOs\UpdateCategoryDTO;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function getAll(string $restaurantId, int $perPage): LengthAwarePaginator;

    public function findOne(string $id): Category;

    public function new(CreateCategoryDTO $dto): Category;

    public function update(string $id, UpdateCategoryDTO $dto): Category;

    public function delete(string $id): void;

    public function alreadyExistsInRestaurant(string $name, int $restaurantId): bool;
}
