<?php

namespace App\Http\Controllers;

use App\DTOs\CreateRestaurantDTO;
use App\DTOs\UpdateRestaurantDTO;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Http\Resources\RestaurantResource;
use App\Services\RestaurantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class RestaurantController extends Controller
{
    public function __construct(
        protected RestaurantService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 10), 100);

        return RestaurantResource::collection($this->service->getAll($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestaurantRequest $request): JsonResponse
    {
        $restaurant = $this->service->new(
            CreateRestaurantDTO::fromRequest($request)
        );

        return response()->json(new RestaurantResource($restaurant), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $restaurant = $this->service->findOne($id);

        return response()->json(new RestaurantResource($restaurant), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantRequest $request, string $id)
    {
        $restaurant = $this->service->update(
            $id,
            UpdateRestaurantDTO::fromRequest($request)
        );

        return response()->json(new RestaurantResource($restaurant), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        $this->service->delete($id);

        return response()->noContent();
    }
}
