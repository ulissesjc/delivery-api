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
     * @OA\Get(
     *  path="/api/restaurants",
     *  summary="Listar restaurantes",
     *  tags={"Restaurantes"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\Parameter(name="per_page", in="query", required=false,
     *
     *      @OA\Schema(type="integer", example=10)
     *  ),
     *
     *  @OA\Response(
     *      response=200,
     *      description="Lista paginada de restaurantes",
     *
     *      @OA\JsonContent(
     *
     *          @OA\Property(
     *              property="data",
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/Restaurant")
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

        return RestaurantResource::collection($this->service->getAll($perPage));
    }

    /**
     * @OA\Post(
     *  path="/api/restaurants",
     *  summary="Cadastrar restaurante",
     *  tags={"Restaurantes"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\RequestBody(
     *      required=true,
     *
     *      @OA\JsonContent(
     *          required={"name", "address"},
     *
     *          @OA\Property(property="name", type="string", example="Burger House"),
     *          @OA\Property(property="address", type="string", example="Rua das Flores, 123, Centro, Aracaju - SE")
     *      )
     *  ),
     *
     *  @OA\Response(
     *      response=201,
     *      description="Restaurante cadastrado com sucesso",
     *
     *      @OA\JsonContent(ref="#/components/schemas/Restaurant")
     *  ),
     *
     *   @OA\Response(response=422, description="Erro de validação dos campos"),
     *   @OA\Response(response=401, description="Não autenticado"),
     * )
     */
    public function store(StoreRestaurantRequest $request): JsonResponse
    {
        $restaurant = $this->service->new(
            CreateRestaurantDTO::fromRequest($request)
        );

        return response()->json(new RestaurantResource($restaurant), 201);
    }

    /**
     * @OA\Get(
     *  path="/api/restaurants/{restaurant}",
     *  summary="Exibir restaurante",
     *  tags={"Restaurantes"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\Parameter(name="restaurant", in="path", required=true,
     *
     *      @OA\Schema(type="integer", example=1)
     *  ),
     *
     *  @OA\Response(
     *      response=200,
     *      description="Restaurante encontrado",
     *
     *      @OA\JsonContent(ref="#/components/schemas/Restaurant")
     *  ),
     *
     *  @OA\Response(response=401, description="Não autenticado"),
     *  @OA\Response(response=404, description="Restaurante não encontrado")
     * )
     */
    public function show(string $id): JsonResponse
    {
        $restaurant = $this->service->findOne($id);

        return response()->json(new RestaurantResource($restaurant), 200);
    }

    /**
     * @OA\Patch(
     *  path="/api/restaurants/{restaurant}",
     *  summary="Atualizar restaurante",
     *  tags={"Restaurantes"},
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
     *
     *          @OA\Property(property="name", type="string", example="Burger Home"),
     *          @OA\Property(property="address", type="string", example="Rua das Flores, 124, Luzia, Aracaju - SE"),
     *      )
     *  ),
     *
     *  @OA\Response(response=200, description="Restaurante atualizado com sucesso",
     *
     *      @OA\JsonContent(
     *
     *          @OA\Property(property="id", type="integer", example=1),
     *          @OA\Property(property="name", type="string", example="Burger Home"),
     *          @OA\Property(property="address", type="string", example="Rua das Flores, 124, Luzia, Aracaju - SE"),
     *      )
     *  ),
     *
     *   @OA\Response(response=401, description="Não autenticado"),
     *   @OA\Response(response=404, description="Restaurante não encontrado"),
     *   @OA\Response(response=422, description="Erro de validação dos campos")
     * )
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
     * @OA\Delete(
     *     path="/api/restaurants/{restaurant}",
     *     summary="Remover restaurante",
     *     tags={"Restaurantes"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(name="restaurant", in="path", required=true,
     *
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(response=204, description="Restaurante removido com sucesso"),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=404, description="Restaurante não encontrado")
     * )
     */
    public function destroy(string $id): Response
    {
        $this->service->delete($id);

        return response()->noContent();
    }
}
