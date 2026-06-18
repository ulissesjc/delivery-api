<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 *  schema="Order",
 *  type="object",
 *
 *  @OA\Property(property="id", type="integer", example=1),
 *  @OA\Property(
 *      property="restaurant",
 *      type="object",
 *      @OA\Property(property="id", type="integer", example=1),
 *      @OA\Property(property="name", type="string", example="Burger House"),
 *      @OA\Property(property="address", type="string", example="Rua das Flores, 123, Centro, Aracaju - SE")
 *  ),
 *  @OA\Property(
 *      property="items",
 *      type="array",
 *
 *      @OA\Items(
 *          type="object",
 *
 *          @OA\Property(property="id", type="integer", example=1),
 *          @OA\Property(property="product_id", type="integer", example=1),
 *          @OA\Property(property="product_name", type="string", example="X-Burguer Clássico"),
 *          @OA\Property(property="quantity", type="integer", example=3),
 *          @OA\Property(property="unit_price", type="number", format="float", example=24.90),
 *          @OA\Property(property="subtotal", type="number", format="float", example=74.70)
 *      )
 *  ),
 *          @OA\Property(property="status", type="string", example="PENDING"),
 *          @OA\Property(property="total", type="number", format="float", example=74.70)
 * )
 */
class OrderSchema {}
