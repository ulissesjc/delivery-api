<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class RestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = [
            [
                'name' => 'Burger House',
                'address' => 'Rua das Flores, 123, Centro, Aracaju - SE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pizza Roma',
                'address' => 'Av. Beira Mar, 456, Atalaia, Aracaju - SE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sushi Zen',
                'address' => 'Rua Lagarto, 789, Salgado, Aracaju - SE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Churrascaria do Sul',
                'address' => 'Av. Tancredo Neves, 321, Farolândia, Aracaju - SE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tapiocaria Nordestina',
                'address' => 'Rua Santo Amaro, 654, São José, Aracaju - SE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Restaurant::insert($restaurants);
    }
}
