<?php

namespace App\Http\Controllers;

use App\DTOs\CreateCategoryDTO;
use App\DTOs\UpdateCategoryDTO;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 10), 100);

        return CategoryResource::collection($this->service->getAll($request->route('restaurant'), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->service->new(
            CreateCategoryDTO::fromRequest($request)
        );

        return response()->json(new CategoryResource($category), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $category = $this->service->findOne($id);

        return response()->json(new CategoryResource($category), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id): JsonResponse
    {
        $category = $this->service->update(
            $id,
            UpdateCategoryDTO::fromRequest($request)
        );

        return response()->json(new CategoryResource($category), 200);
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
