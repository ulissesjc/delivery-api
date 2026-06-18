<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'name' => 'X-Burguer Clássico',
                'price' => 24.90,
                'description' => 'Pão brioche, blend 150g, queijo cheddar e molho especial',
                'is_available' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'name' => 'Smash Duplo',
                'price' => 32.90,
                'description' => 'Dois blends smash, queijo americano e pickles',
                'is_available' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'name' => 'Crispy Chicken',
                'price' => 28.90,
                'description' => 'Frango empanado crocante, alface e maionese',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 2,
                'name' => 'Coca-Cola 350ml',
                'price' => 6.00,
                'description' => 'Lata gelada',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'name' => 'Shake de Chocolate',
                'price' => 14.90,
                'description' => 'Sorvete de chocolate batido com leite',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 3,
                'name' => 'Brownie com Sorvete',
                'price' => 16.90,
                'description' => 'Brownie quente com sorvete de creme',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 4,
                'name' => 'Margherita',
                'price' => 42.90,
                'description' => 'Molho de tomate, mussarela e manjericão',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4,
                'name' => 'Calabresa',
                'price' => 44.90,
                'description' => 'Molho de tomate, calabresa fatiada e cebola',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4,
                'name' => 'Frango com Catupiry',
                'price' => 46.90,
                'description' => 'Frango desfiado com catupiry cremoso',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 5,
                'name' => 'Nutella com Morango',
                'price' => 49.90,
                'description' => 'Nutella generosa com morangos frescos',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 6,
                'name' => 'Suco de Laranja 500ml',
                'price' => 8.90,
                'description' => 'Suco natural gelado',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 7,
                'name' => 'Combinado Zen 20 peças',
                'price' => 54.90,
                'description' => 'Seleção de niguiris, uramakis e hossomakis',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 7,
                'name' => 'Combinado Especial 30 peças',
                'price' => 79.90,
                'description' => 'Peças variadas com salmão, atum e camarão',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 8,
                'name' => 'Temaki Salmão',
                'price' => 22.90,
                'description' => 'Cone de alga com salmão e cream cheese',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 8,
                'name' => 'Temaki Camarão',
                'price' => 24.90,
                'description' => 'Cone de alga com camarão empanado',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 9,
                'name' => 'Chá Verde Gelado',
                'price' => 7.90,
                'description' => 'Chá verde natural gelado 300ml',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 10,
                'name' => 'Picanha 300g',
                'price' => 89.90,
                'description' => 'Picanha grelhada na brasa com sal grosso',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 10,
                'name' => 'Costela Bovina 400g',
                'price' => 74.90,
                'description' => 'Costela assada lentamente por 12 horas',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 10,
                'name' => 'Fraldinha 250g',
                'price' => 64.90,
                'description' => 'Fraldinha grelhada com alho e ervas',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 11,
                'name' => 'Farofa Especial',
                'price' => 12.90,
                'description' => 'Farofa com bacon, ovos e cheiro-verde',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 11,
                'name' => 'Arroz com Feijão',
                'price' => 10.90,
                'description' => 'Arroz branco e feijão temperado',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 12,
                'name' => 'Cerveja Heineken 600ml',
                'price' => 16.90,
                'description' => 'Long neck gelada',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 13,
                'name' => 'Tapioca de Frango',
                'price' => 18.90,
                'description' => 'Frango desfiado com queijo coalho',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 13,
                'name' => 'Tapioca de Carne Seca',
                'price' => 21.90,
                'description' => 'Carne seca desfiada com manteiga de garrafa',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 13,
                'name' => 'Tapioca de Camarão',
                'price' => 24.90,
                'description' => 'Camarão temperado com catupiry',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 14,
                'name' => 'Tapioca de Coco com Leite Condensado',
                'price' => 16.90,
                'description' => 'Coco ralado com leite condensado cremoso',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 14,
                'name' => 'Tapioca de Chocolate',
                'price' => 17.90,
                'description' => 'Nutella com banana caramelizada',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 15,
                'name' => 'Vitamina de Acerola',
                'price' => 9.90,
                'description' => 'Vitamina natural de acerola 400ml',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Product::insert($products);
    }
}
