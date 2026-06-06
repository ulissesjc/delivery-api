<?php

namespace App\Repositories\Contracts;

use App\DTOs\StoreRestaurantDTO;
use App\DTOs\UpdateRestaurantDTO;
use App\Models\Restaurant;
use Illuminate\Pagination\LengthAwarePaginator;

interface RestaurantRepositoryInterface
{
    public function getAll(int $perPage): LengthAwarePaginator;

    public function findOne(string $id): Restaurant;

    public function new(StoreRestaurantDTO $dto): Restaurant;

    public function update(string $id, UpdateRestaurantDTO $dto): Restaurant;

    public function delete(string $id): void;
}
