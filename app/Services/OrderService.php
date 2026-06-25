<?php

namespace App\Services;

use App\DTOs\CreateOrderDTO;
use App\DTOs\UpdateOrderStatusDTO;
use App\Exceptions\BusinessException;
use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Restaurant\RestaurantRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        protected OrderRepositoryInterface $orderRepository,
        protected ProductRepositoryInterface $productRepository,
        protected RestaurantRepositoryInterface $restaurantRepository
    ) {}

    public function getAll(string $restaurantId, int $perPage): LengthAwarePaginator
    {
        $this->restaurantRepository->findOne($restaurantId);

        return $this->orderRepository->getAll($restaurantId, $perPage);
    }

    public function findOne(string $id): Order
    {
        return $this->orderRepository->findOne($id);
    }

    public function new(CreateOrderDTO $dto): Order
    {
        $this->restaurantRepository->findOne($dto->restaurant_id);

        return DB::transaction(function () use ($dto) {
            $total = 0;
            $items = [];

            foreach ($dto->items as $item) {
                $product = $this->productRepository->findAvailableInRestaurant($item->product_id, $dto->restaurant_id);

                if (! $product) {
                    throw new BusinessException("Produto {$item->product_id} não está disponível para este restaurante");
                }

                $subtotal = $product->price * $item->quantity;
                $total += $subtotal;

                $items[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ];
            }

            return $this->orderRepository->new($dto, $items, $total);
        });
    }

    public function updateStatus(string $id, UpdateOrderStatusDTO $dto): Order
    {
        return $this->orderRepository->updateStatus($id, $dto);
    }
}
