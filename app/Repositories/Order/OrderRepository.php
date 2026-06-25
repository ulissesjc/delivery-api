<?php

namespace App\Repositories;

use App\DTOs\CreateOrderDTO;
use App\DTOs\UpdateOrderStatusDTO;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(
        protected Order $model
    ) {}

    public function getAll(string $restaurantId, int $perPage): LengthAwarePaginator
    {
        return $this->model
            ->where('restaurant_id', $restaurantId)
            ->with(['restaurant', 'items.product'])
            ->paginate($perPage);
    }

    public function findOne(string $id): Order
    {
        return $this->model
            ->with(['restaurant', 'items.product'])
            ->findOrFail($id);
    }

    public function new(CreateOrderDTO $dto, array $items, float $total): Order
    {
        $order = $this->model->create([
            'restaurant_id' => $dto->restaurant_id,
            'status' => OrderStatus::PENDING,
            'total' => $total,
        ]);

        $order->items()->createMany($items);

        return $order->load(['restaurant', 'items.product']);
    }

    public function updateStatus(string $id, UpdateOrderStatusDTO $dto): Order
    {
        $order = $this->model->findOrFail($id);

        $order->update(['status' => $dto->status]);

        return $order->fresh(['restaurant', 'items.product']);
    }
}
