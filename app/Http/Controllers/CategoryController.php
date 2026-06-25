<?php

namespace App\Http\Controllers;

use App\DTOs\Category\CreateCategoryDTO;
use App\DTOs\Category\UpdateCategoryDTO;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
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
     * @OA\Get(
     *  path="/api/restaurants/{restaurant}/categories",
     *  summary="Listar categorias do restaurante",
     *  tags={"Categorias"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\Parameter(name="restaurant", in="path", required=true,
     *
     *      @OA\Schema(type="integer", example=1)
     *  ),
     *
     *  @OA\Parameter(name="per_page", in="query", required=false,
     *
     *      @OA\Schema(type="integer", example=10)
     *  ),
     *
     *  @OA\Response(
     *      response=200,
     *      description="Lista paginada de categorias",
     *
     *      @OA\JsonContent(
     *
     *          @OA\Property(
     *              property="data",
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/Category")
     *          ),
     *
     *          @OA\Property(property="links", type="object"),
     *          @OA\Property(property="meta", type="object")
     *      )
     *  ),
     *
     *  @OA\Response(response=401, description="Não autenticado")
     * )
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 10), 100);

        return CategoryResource::collection($this->service->getAll($request->route('restaurant'), $perPage));
    }

    /**
     * @OA\Post(
     *  path="/api/restaurants/{restaurant}/categories",
     *  summary="Cadastrar categoria no restaurante",
     *  tags={"Categorias"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\Parameter(name="restaurant", in="path", required=true,
     *
     *      @OA\Schema(type="integer", example=1)
     *  ),
     *
     *  @OA\RequestBody(
     *      required=true,
     *
     *      @OA\JsonContent(
     *          required={"name"},
     *
     *          @OA\Property(property="name", type="string", example="Hambúrgueres"),
     *          @OA\Property(property="description", type="string", example="Artesanais e smash burgers")
     *      )
     *  ),
     *
     *  @OA\Response(
     *      response=201,
     *      description="Categoria cadastrada com sucesso",
     *
     *      @OA\JsonContent(ref="#/components/schemas/Category")
     *  ),
     *
     *  @OA\Response(response=422, description="Erro de validação dos campos"),
     *  @OA\Response(response=401, description="Não autenticado"),
     * )
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->service->new(
            CreateCategoryDTO::fromRequest($request)
        );

        return response()->json(new CategoryResource($category), 201);
    }

    /**
     * @OA\Get(
     *  path="/api/categories/{category}",
     *  summary="Exibir categoria",
     *  tags={"Categorias"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\Parameter(name="category", in="path", required=true,
     *
     *      @OA\Schema(type="integer", example=1)
     *  ),
     *
     *  @OA\Response(
     *      response=200,
     *      description="Categoria encontrada",
     *
     *      @OA\JsonContent(ref="#/components/schemas/Category")
     *  ),
     *
     *  @OA\Response(response=401, description="Não autenticado"),
     *  @OA\Response(response=404, description="Categoria não encontrada")
     * )
     */
    public function show(string $id): JsonResponse
    {
        $category = $this->service->findOne($id);

        return response()->json(new CategoryResource($category), 200);
    }

    /**
     * @OA\Patch(
     *  path="/api/categories/{category}",
     *  summary="Atualizar categoria",
     *  tags={"Categorias"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\Parameter(name="category", in="path", required=true,
     *
     *      @OA\Schema(type="integer", example=1)
     *  ),
     *
     *  @OA\RequestBody(
     *      required=true,
     *
     *      @OA\JsonContent(
     *
     *          @OA\Property(property="name", type="string", example="Hambúrgueres"),
     *          @OA\Property(property="description", type="string", example="Artesanais e smash burgers duplo"),
     *      )
     *  ),
     *
     *  @OA\Response(response=200, description="Categoria atualizada com sucesso",
     *
     *      @OA\JsonContent(
     *
     *          @OA\Property(property="id", type="integer", example=1),
     *          @OA\Property(property="name", type="string", example="Hambúrgueres"),
     *          @OA\Property(property="description", type="string", example="Artesanais e smash burgers duplo"),
     *          @OA\Property(property="restaurant", ref="#/components/schemas/Restaurant")
     *      ),
     *  ),
     *
     *   @OA\Response(response=401, description="Não autenticado"),
     *   @OA\Response(response=404, description="Categoria não encontrado"),
     *   @OA\Response(response=422, description="Erro de validação dos campos")
     * )
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
     * @OA\Delete(
     *     path="/api/categories/{category}",
     *     summary="Remover categoria",
     *     tags={"Categorias"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(name="category", in="path", required=true,
     *
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(response=204, description="Categoria removida com sucesso"),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=404, description="Categoria não encontrada")
     * )
     */
    public function destroy(string $id): Response
    {
        $this->service->delete($id);

        return response()->noContent();
    }
}
