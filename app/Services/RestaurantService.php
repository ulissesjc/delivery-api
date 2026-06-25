<?php

namespace App\Services;

use App\DTOs\Restaurant\CreateRestaurantDTO;
use App\DTOs\Restaurant\UpdateRestaurantDTO;
use App\Models\Restaurant;
use App\Repositories\Restaurant\RestaurantRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RestaurantService
{
    public function __construct(
        protected RestaurantRepositoryInterface $repository
    ) {}

    public function getAll(int $perPage): LengthAwarePaginator
    {
        return $this->repository->getAll($perPage);
    }

    public function findOne(string $id): Restaurant
    {
        return $this->repository->findOne($id);
    }

    public function new(CreateRestaurantDTO $dto): Restaurant
    {
        return $this->repository->new($dto);
    }

    public function update(string $id, UpdateRestaurantDTO $dto): Restaurant
    {
        return $this->repository->update($id, $dto);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }
}
