<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 *  schema="Restaurant",
 *  type="object",
 *
 *  @OA\Property(property="id", type="integer", example=1),
 *  @OA\Property(property="name", type="string", example="Burger House"),
 *  @OA\Property(property="address", type="string", example="Rua das Flores, 123, Centro, Aracaju - SE")
 * )
 */
class RestaurantSchema {}
