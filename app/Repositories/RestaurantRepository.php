<?php

namespace App\Repositories;

use App\DTOs\StoreRestaurantDTO;
use App\DTOs\UpdateRestaurantDTO;
use App\Models\Restaurant;
use App\Repositories\Contracts\RestaurantRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RestaurantRepository implements RestaurantRepositoryInterface
{
    public function __construct(
        protected Restaurant $model
    ) {}

    public function getAll(int $perPage): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function findOne(string $id): Restaurant
    {
        return $this->model->findOrFail($id);
    }

    public function new(StoreRestaurantDTO $dto): Restaurant
    {
        return $this->model->create((array) $dto);
    }

    public function update(string $id, UpdateRestaurantDTO $dto): Restaurant
    {
        $restaurant = $this->model->findOrFail($id);
        $restaurant->update(array_filter((array) $dto, fn ($value) => ! is_null($value)));

        return $restaurant->fresh();
    }

    public function delete(string $id): void
    {
        $this->model->findOrFail($id)->delete();
    }
}
