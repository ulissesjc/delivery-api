<?php

namespace App\Services;

use App\DTOs\CreateCategoryDTO;
use App\DTOs\UpdateCategoryDTO;
use App\Exceptions\BusinessException;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $repository
    ) {}

    public function getAll(string $restaurantId, int $perPage): LengthAwarePaginator
    {
        return $this->repository->getAll($restaurantId, $perPage);
    }

    public function findOne(string $id): Category
    {
        return $this->repository->findOne($id);
    }

    public function new(CreateCategoryDTO $dto): Category
    {
        if ($this->repository->alreadyExistsInRestaurant($dto->name, $dto->restaurant_id)) {
            throw new BusinessException('Esta categoria já está cadastrada neste restaurante');
        }

        return $this->repository->new($dto);
    }

    public function update(string $id, UpdateCategoryDTO $dto): Category
    {
        return $this->repository->update($id, $dto);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }
}
