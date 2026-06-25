<?php

namespace App\Repositories\Product;

use App\DTOs\Product\CreateProductDTO;
use App\DTOs\Product\UpdateProductDTO;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function getAll(string $categoryId, int $perPage): LengthAwarePaginator;

    public function findOne(string $id): Product;

    public function new(CreateProductDTO $dto): Product;

    public function update(string $id, UpdateProductDTO $dto): Product;

    public function delete(string $id): void;

    public function findByNameInCategory(string $name, int $categoryId): ?Product;

    public function findAvailableInRestaurant(string $id, string $restaurantId): ?Product;
}
