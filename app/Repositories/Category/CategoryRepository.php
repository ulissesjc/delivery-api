<?php

namespace App\Repositories;

use App\DTOs\CreateCategoryDTO;
use App\DTOs\UpdateCategoryDTO;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(
        protected Category $model,
    ) {}

    public function getAll(string $restaurantId, int $perPage): LengthAwarePaginator
    {
        return $this->model->where('restaurant_id', $restaurantId)->with('restaurant')->paginate($perPage);
    }

    public function findOne(string $id): Category
    {
        return $this->model->with('restaurant')->findOrFail($id);
    }

    public function new(CreateCategoryDTO $dto): Category
    {
        $category = $this->model->create((array) $dto);

        return $category->load('restaurant');
    }

    public function update(string $id, UpdateCategoryDTO $dto): Category
    {
        $category = $this->model->findOrFail($id);
        $category->update(array_filter((array) $dto, fn ($value) => ! is_null($value)));

        return $category->fresh(['restaurant']);
    }

    public function delete(string $id): void
    {
        $this->model->findOrFail($id)->delete();
    }

    public function findByNameInRestaurant(string $name, int $restaurantId): ?Category
    {
        return $this->model
            ->withTrashed()
            ->where('restaurant_id', $restaurantId)
            ->where('name', $name)
            ->first();
    }
}
