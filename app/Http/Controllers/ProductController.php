<?php

namespace App\Http\Controllers;

use App\DTOs\CreateProductDTO;
use App\DTOs\UpdateProductDTO;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 10), 100);

        return ProductResource::collection($this->service->getAll($request->route('category'), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->service->new(
            CreateProductDTO::fromRequest($request)
        );

        return response()->json(new ProductResource($product), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $product = $this->service->findOne($id);

        return response()->json(new ProductResource($product), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id): JsonResponse
    {
        $product = $this->service->update(
            $id,
            UpdateProductDTO::fromRequest($request)
        );

        return response()->json(new ProductResource($product), 200);
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
