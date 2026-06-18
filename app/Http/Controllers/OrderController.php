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
     * @OA\Get(
     *  path="/api/restaurants/{restaurant}/orders",
     *  summary="Listar pedidos do restaurante",
     *  tags={"Pedidos"},
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
     *      description="Lista paginada de pedidos",
     *
     *      @OA\JsonContent(
     *
     *          @OA\Property(
     *              property="data",
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/Order")
     *          ),
     *
     *          @OA\Property(property="links", type="object"),
     *          @OA\Property(property="meta", type="object")
     *      )
     *  ),
     *
     *  @OA\Response(response=401, description="Não autenticado"),
     *  @OA\Response(response=404, description="Restaurante não encontrado")
     * )
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 10), 100);

        return OrderResource::collection($this->service->getAll($request->route('restaurant'), $perPage));
    }

    /**
     * @OA\Post(
     *  path="/api/restaurants/{restaurant}/orders",
     *  summary="Cadastrar pedido",
     *  tags={"Pedidos"},
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
     *          required={"items"},
     *
     *          @OA\Property(
     *              property="items",
     *              type="array",
     *
     *              @OA\Items(
     *                  type="object",
     *                  required={"product_id", "quantity"},
     *
     *                  @OA\Property(property="product_id", type="integer", example=1),
     *                  @OA\Property(property="quantity", type="integer", example=3)
     *              )
     *          )
     *      )
     *  ),
     *
     *  @OA\Response(
     *      response=201,
     *      description="Pedido cadastrado com sucesso",
     *
     *      @OA\JsonContent(ref="#/components/schemas/Order")
     *  ),
     *
     *   @OA\Response(response=422, description="Erro de validação dos campos"),
     *   @OA\Response(response=401, description="Não autenticado"),
     *   @OA\Response(response=404, description="Restaurante não encontrado")
     * )
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->service->new(
            CreateOrderDTO::fromRequest($request)
        );

        return response()->json(new OrderResource($order), 201);
    }

    /**
     * @OA\Get(
     *  path="/api/orders/{order}",
     *  summary="Exibir pedido",
     *  tags={"Pedidos"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\Parameter(name="order", in="path", required=true,
     *
     *      @OA\Schema(type="integer", example=1)
     *  ),
     *
     *  @OA\Response(
     *      response=200,
     *      description="Pedido encontrado",
     *
     *      @OA\JsonContent(ref="#/components/schemas/Order")
     *  ),
     *
     *  @OA\Response(response=401, description="Não autenticado"),
     *  @OA\Response(response=404, description="Pedido não encontrado")
     * )
     */
    public function show(string $id): JsonResponse
    {
        $order = $this->service->findOne($id);

        return response()->json(new OrderResource($order), 200);
    }

    /**
     * @OA\Patch(
     *  path="/api/orders/{order}/status",
     *  summary="Atualizar status do pedido",
     *  tags={"Pedidos"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\Parameter(name="order", in="path", required=true,
     *
     *      @OA\Schema(type="integer", example=1)
     *  ),
     *
     *  @OA\RequestBody(
     *      required=true,
     *
     *      @OA\JsonContent(
     *
     *          @OA\Property(
     *              property="status",
     *              type="string",
     *              enum={"PENDING", "PREPARING", "OUT_FOR_DELIVERY", "COMPLETED", "CANCELED"},
     *              example="PREPARING"
     *          )
     *      )
     *  ),
     *
     *  @OA\Response(
     *      response=200,
     *      description="Status do pedido atualizado com sucesso",
     *
     *      @OA\JsonContent(
     *          allOf={
     *
     *              @OA\Schema(ref="#/components/schemas/Order")
     *          },
     *
     *          @OA\Property(
     *              property="status",
     *              type="string",
     *              example="PREPARING"
     *          )
     *      )
     *  ),
     *
     *   @OA\Response(response=401, description="Não autenticado"),
     *   @OA\Response(response=404, description="Pedido não encontrado"),
     *   @OA\Response(response=422, description="Erro de validação dos campos")
     * )
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
