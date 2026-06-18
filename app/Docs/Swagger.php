<?php

namespace App\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Delivery API",
 *     version="1.0.0",
 *     description="API para gerenciamento de restaurantes, categorias, produtos e pedidos",
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Servidor Local"
 * )
 *
 * @OA\SecurityScheme(
 *  securityScheme="bearerAuth",
 *  type="http",
 *  scheme="bearer"
 * )
 */
class Swagger {}
