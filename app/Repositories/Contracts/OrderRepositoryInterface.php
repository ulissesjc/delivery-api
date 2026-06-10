<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateOrderDTO;
use App\DTOs\UpdateOrderStatusDTO;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function getAll(string $restaurantId, int $perPage): LengthAwarePaginator;

    public function findOne(string $id): Order;

    public function new(CreateOrderDTO $dto, array $items, float $total): Order;

    public function updateStatus(string $id, UpdateOrderStatusDTO $dto): Order;
}
