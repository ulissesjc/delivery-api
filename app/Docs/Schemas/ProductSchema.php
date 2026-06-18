<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 *  schema="Product",
 *  type="object",
 *
 *  @OA\Property(property="id", type="integer", example=1),
 *  @OA\Property(property="name", type="string", example="X-Burguer Clássico"),
 *  @OA\Property(property="price", type="number", example=24.90),
 *  @OA\Property(property="description", type="string", example="Pão brioche, blend 150g, queijo cheddar e molho especial"),
 *  @OA\Property(property="is_available", type="bool", example=true),
 *  @OA\Property(
 *      property="category",
 *      type="object",
 *      @OA\Property(property="id", type="integer", example=1),
 *      @OA\Property(property="name", type="string", example="Hambúrgueres"),
 *      @OA\Property(property="description", type="string", example="Artesanais e smash burgers")
 *  )
 * )
 */
class ProductSchema {}
