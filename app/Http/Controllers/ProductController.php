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
     * @OA\Get(
     *  path="/api/categories/{category}/products",
     *  summary="Listar produtos de uma categoria",
     *  tags={"Produtos"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\Parameter(name="category", in="path", required=true,
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
     *      description="Lista paginada de produtos",
     *
     *      @OA\JsonContent(
     *
     *          @OA\Property(
     *              property="data",
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/Product")
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

        return ProductResource::collection($this->service->getAll($request->route('category'), $perPage));
    }

    /**
     * @OA\Post(
     *  path="/api/categories/{category}/products",
     *  summary="Cadastrar produto em uma categoria",
     *  tags={"Produtos"},
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
     *          required={"name", "price"},
     *
     *          @OA\Property(property="name", type="string", example="X-Burguer Clássico"),
     *          @OA\Property(property="price", type="number", example=24.90),
     *          @OA\Property(property="description", type="string", example="Pão brioche, blend 150g, queijo cheddar e molho especial"),
     *          @OA\Property(property="is_available", type="boolean", example=true)
     *      )
     *  ),
     *
     *  @OA\Response(response=201, description="Produto cadastrado com sucesso",
     *
     *      @OA\JsonContent(ref="#/components/schemas/Product")
     *  ),
     *
     *   @OA\Response(response=422, description="Erro de validação dos campos"),
     *   @OA\Response(response=401, description="Não autenticado"),
     * )
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->service->new(
            CreateProductDTO::fromRequest($request)
        );

        return response()->json(new ProductResource($product), 201);
    }

    /**
     * @OA\Get(
     *  path="/api/products/{product}",
     *  summary="Exibir produto",
     *  tags={"Produtos"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\Parameter(name="product", in="path", required=true,
     *
     *      @OA\Schema(type="integer", example=1)
     *  ),
     *
     *  @OA\Response(
     *      response=200,
     *      description="Produto encontrado",
     *
     *      @OA\JsonContent(ref="#/components/schemas/Product")
     *  ),
     *
     *  @OA\Response(response=401, description="Não autenticado"),
     *  @OA\Response(response=404, description="Produto não encontrado")
     * )
     */
    public function show(string $id): JsonResponse
    {
        $product = $this->service->findOne($id);

        return response()->json(new ProductResource($product), 200);
    }

    /**
     * @OA\Patch(
     *  path="/api/products/{product}",
     *  summary="Atualizar produto",
     *  tags={"Produtos"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\Parameter(name="product", in="path", required=true,
     *
     *      @OA\Schema(type="integer", example=1)
     *  ),
     *
     *  @OA\RequestBody(
     *      required=true,
     *
     *      @OA\JsonContent(
     *
     *          @OA\Property(property="name", type="string", example="X-Burguer"),
     *          @OA\Property(property="price", type="number", example=22.90),
     *          @OA\Property(property="description", type="string", example="Pão brioche, blend 150g e queijo cheddar"),
     *          @OA\Property(property="is_available", type="boolean", example=true)
     *      )
     *  ),
     *
     *  @OA\Response(response=200, description="Produto atualizado com sucesso",
     *
     *      @OA\JsonContent(
     *
     *          @OA\Property(property="id", type="integer", example=1),
     *          @OA\Property(property="name", type="string", example="X-Burguer"),
     *          @OA\Property(property="price", type="number", example=22.90),
     *          @OA\Property(property="description", type="string", example="Pão brioche, blend 150g e queijo cheddar"),
     *          @OA\Property(property="is_available", type="boolean", example=true),
     *          @OA\Property(
     *              property="category",
     *              type="object",
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="Hambúrgueres"),
     *              @OA\Property(property="description", type="string", example="Artesanais e smash burgers")
     *          )
     *      ),
     *  ),
     *
     *   @OA\Response(response=401, description="Não autenticado"),
     *   @OA\Response(response=404, description="Produto não encontrado"),
     *   @OA\Response(response=422, description="Erro de validação dos campos")
     * )
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
     * @OA\Delete(
     *     path="/api/products/{product}",
     *     summary="Remover produto",
     *     tags={"Produtos"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(name="product", in="path", required=true,
     *
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(response=204, description="Produto removido com sucesso"),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=404, description="Produto não encontrado")
     * )
     */
    public function destroy(string $id): Response
    {
        $this->service->delete($id);

        return response()->noContent();
    }
}
