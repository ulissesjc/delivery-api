<?php

namespace App\Services;

use App\DTOs\Category\CreateCategoryDTO;
use App\DTOs\Category\UpdateCategoryDTO;
use App\Exceptions\BusinessException;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Restaurant\RestaurantRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
        protected RestaurantRepositoryInterface $restaurantRepository
    ) {}

    public function getAll(string $restaurantId, int $perPage): LengthAwarePaginator
    {
        return $this->categoryRepository->getAll($restaurantId, $perPage);
    }

    public function findOne(string $id): Category
    {
        return $this->categoryRepository->findOne($id);
    }

    public function new(CreateCategoryDTO $dto): Category
    {
        $this->restaurantRepository->findOne($dto->restaurant_id);

        $category = $this->categoryRepository->findByNameInRestaurant($dto->name, $dto->restaurant_id);

        if ($category) {
            if ($category->trashed()) {
                $category->restore();

                return $category;
            }

            throw new BusinessException('Esta categoria já está cadastrada neste restaurante');
        }

        return $this->categoryRepository->new($dto);
    }

    public function update(string $id, UpdateCategoryDTO $dto): Category
    {
        return $this->categoryRepository->update($id, $dto);
    }

    public function delete(string $id): void
    {
        $this->categoryRepository->delete($id);
    }
}
