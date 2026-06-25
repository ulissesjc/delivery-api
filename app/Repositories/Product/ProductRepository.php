<?php

namespace App\Repositories\Product;

use App\DTOs\Product\CreateProductDTO;
use App\DTOs\Product\UpdateProductDTO;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        protected Product $model
    ) {}

    public function getAll(string $categoryId, int $perPage): LengthAwarePaginator
    {
        return $this->model->where('category_id', $categoryId)->with('category')->paginate($perPage);
    }

    public function findOne(string $id): Product
    {
        return $this->model->with('category')->findOrFail($id);
    }

    public function new(CreateProductDTO $dto): Product
    {
        $product = $this->model->create((array) $dto);

        return $product->load('category');
    }

    public function update(string $id, UpdateProductDTO $dto): Product
    {
        $product = $this->model->findOrFail($id);

        $product->update(array_filter((array) $dto, fn ($value) => ! is_null($value)));

        return $product->fresh(['category']);
    }

    public function delete(string $id): void
    {
        $this->model->findOrFail($id)->delete();
    }

    public function findByNameInCategory(string $name, int $categoryId): ?Product
    {
        return $this->model
            ->withTrashed()
            ->where('category_id', $categoryId)
            ->where('name', $name)
            ->first();
    }

    public function findAvailableInRestaurant(string $id, string $restaurantId): ?Product
    {
        return $this->model
            ->whereKey($id)
            ->where('is_available', true)
            ->whereHas('category', function ($query) use ($restaurantId) {
                $query->where('restaurant_id', $restaurantId);
            })
            ->first();
    }
}
