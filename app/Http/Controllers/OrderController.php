<?php

namespace App\Http\Controllers;

use App\DTOs\CreateOrderDTO;
use App\DTOs\UpdateOrderStatusDTO;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderStatus;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 10), 100);

        return OrderResource::collection($this->service->getAll($request->route('restaurant'), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->service->new(
            CreateOrderDTO::fromRequest($request)
        );

        return response()->json(new OrderResource($order), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $order = $this->service->findOne($id);

        return response()->json(new OrderResource($order), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(UpdateOrderStatus $request, string $id): JsonResponse
    {
        $order = $this->service->updateStatus(
            $id,
            UpdateOrderStatusDTO::fromRequest($request)
        );

        return response()->json(new OrderResource($order), 200);
    }
}
