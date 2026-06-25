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
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Servidor da API"
 * )
 *
 * @OA\SecurityScheme(
 *  securityScheme="bearerAuth",
 *  type="http",
 *  scheme="bearer"
 * )
 */
class Swagger {}
