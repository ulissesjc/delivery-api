<?php

namespace App\Repositories\Restaurant;

use App\DTOs\Restaurant\CreateRestaurantDTO;
use App\DTOs\Restaurant\UpdateRestaurantDTO;
use App\Models\Restaurant;
use Illuminate\Pagination\LengthAwarePaginator;

interface RestaurantRepositoryInterface
{
    public function getAll(int $perPage): LengthAwarePaginator;

    public function findOne(string $id): Restaurant;

    public function new(CreateRestaurantDTO $dto): Restaurant;

    public function update(string $id, UpdateRestaurantDTO $dto): Restaurant;

    public function delete(string $id): void;
}
