<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 *  schema="Category",
 *  type="object",
 *
 *  @OA\Property(property="id", type="integer", example=1),
 *  @OA\Property(property="name", type="string", example="Hambúrgueres"),
 *  @OA\Property(property="description", type="string", example="Artesanais e smash burgers"),
 *  @OA\Property(property="restaurant", ref="#/components/schemas/Restaurant")
 * )
 */
class CategorySchema {}
