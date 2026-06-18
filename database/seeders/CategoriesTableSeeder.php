<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'restaurant_id' => 1,
                'name' => 'Hambúrgueres',
                'description' => 'Artesanais e smash burgers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'restaurant_id' => 1,
                'name' => 'Bebidas',
                'description' => 'Refrigerantes, sucos e shakes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'restaurant_id' => 1,
                'name' => 'Sobremesas',
                'description' => 'Doces e sorvetes',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'restaurant_id' => 2,
                'name' => 'Pizzas Salgadas',
                'description' => 'Tradicionais e especiais',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'restaurant_id' => 2,
                'name' => 'Pizzas Doces',
                'description' => 'Sobremesas em forma de pizza',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'restaurant_id' => 2,
                'name' => 'Bebidas',
                'description' => 'Refrigerantes e sucos',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'restaurant_id' => 3,
                'name' => 'Combinados',
                'description' => 'Seleções especiais de peças',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'restaurant_id' => 3,
                'name' => 'Temakis',
                'description' => 'Cones de alga com recheios variados',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'restaurant_id' => 3,
                'name' => 'Bebidas',
                'description' => 'Chás, sucos e refrigerantes',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'restaurant_id' => 4,
                'name' => 'Carnes',
                'description' => 'Cortes nobres e tradicionais',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'restaurant_id' => 4,
                'name' => 'Acompanhamentos',
                'description' => 'Arroz, feijão, farofa e mais',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'restaurant_id' => 4,
                'name' => 'Bebidas',
                'description' => 'Refrigerantes, sucos e cervejas',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'restaurant_id' => 5,
                'name' => 'Tapiocas Salgadas',
                'description' => 'Recheios tradicionais e especiais',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'restaurant_id' => 5,
                'name' => 'Tapiocas Doces',
                'description' => 'Recheios doces e cremosos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'restaurant_id' => 5,
                'name' => 'Bebidas',
                'description' => 'Sucos naturais e vitaminas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Category::insert($categories);
    }
}
