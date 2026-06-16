<?php

use App\Enums\OrderStatus;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('test')->plainTextToken;
    $this->restaurant = Restaurant::factory()->create();
    $this->category = Category::factory()->create(['restaurant_id' => $this->restaurant->id]);
    $this->product = Product::factory()->create(['category_id' => $this->category->id]);
});

describe('Testes de Funcionalidade - Pedidos', function () {
    it('retorna 422 ao criar pedido com produto inexistente', function () {
        $this->withToken($this->token)
            ->postJson("/api/restaurants/{$this->restaurant->id}/orders", [
                'items' => [
                    [
                        'product_id' => 999999,
                        'quantity' => 3,
                    ],
                ],
            ])
            ->assertStatus(422)
            ->assertJson(['message' => 'Produto 999999 não está disponível para este restaurante']);
    });

    it('retorna 422 ao criar pedido com produto indisponível', function () {
        $unavailableProduct = Product::factory()->create([
            'category_id' => $this->category->id,
            'is_available' => false,
        ]);

        $this->withToken($this->token)
            ->postJson("/api/restaurants/{$this->restaurant->id}/orders", [
                'items' => [
                    [
                        'product_id' => $unavailableProduct->id,
                        'quantity' => 3,
                    ],
                ],
            ])
            ->assertStatus(422)
            ->assertJson(['message' => "Produto {$unavailableProduct->id} não está disponível para este restaurante"]);
    });

    it('retorna 422 ao criar pedido com produto de outro restaurante', function () {
        $otherRestaurant = Restaurant::factory()->create();
        $otherCategory = Category::factory()->create(['restaurant_id' => $otherRestaurant->id]);
        $otherProduct = Product::factory()->create(['category_id' => $otherCategory->id]);

        $this->withToken($this->token)
            ->postJson("/api/restaurants/{$this->restaurant->id}/orders", [
                'items' => [
                    [
                        'product_id' => $otherProduct->id,
                        'quantity' => 1,
                    ],
                ],
            ])
            ->assertStatus(422)
            ->assertJson(['message' => "Produto {$otherProduct->id} não está disponível para este restaurante"]);
    });

    it('retorna 422 ao criar pedido sem itens', function () {
        $this->withToken($this->token)
            ->postJson("/api/restaurants/{$this->restaurant->id}/orders", [
                'items' => [],
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['items']);
    });

    it('retorna 404 ao criar pedido em restaurante inexistente', function () {
        $this->withToken($this->token)
            ->postJson('/api/restaurants/999999/orders', [
                'items' => [
                    [
                        'product_id' => $this->product->id,
                        'quantity' => 1,
                    ],
                ],
            ])
            ->assertStatus(404)
            ->assertJson(['message' => 'Recurso não encontrado']);
    });

    it('cria pedido com sucesso', function () {
        $this->withToken($this->token)
            ->postJson("/api/restaurants/{$this->restaurant->id}/orders", [
                'items' => [
                    [
                        'product_id' => $this->product->id,
                        'quantity' => 5,
                    ],
                ],
            ])
            ->assertStatus(201)
            ->assertJsonStructure(['id', 'restaurant', 'items', 'status', 'total']);

        $this->assertDatabaseHas('orders', [
            'restaurant_id' => $this->restaurant->id,
            'status' => OrderStatus::PENDING->value,
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $this->product->id,
            'quantity' => 5,
            'unit_price' => $this->product->price,
        ]);
    });

    it('calcula o total do pedido corretamente', function () {
        $otherProduct = Product::factory()->create([
            'category_id' => $this->category->id,
            'price' => 10.00,
        ]);

        $this->product->update(['price' => 15.50]);

        $response = $this->withToken($this->token)
            ->postJson("/api/restaurants/{$this->restaurant->id}/orders", [
                'items' => [
                    [
                        'product_id' => $this->product->id,
                        'quantity' => 3,
                    ],
                    [
                        'product_id' => $otherProduct->id,
                        'quantity' => 5,
                    ],
                ],
            ])
            ->assertStatus(201);

        $response->assertJsonPath('total', '96.50');

        $this->assertDatabaseHas('orders', [
            'id' => $response->json('id'),
            'total' => 96.50,
        ]);
    });

    it('lista pedidos de um restaurante de forma paginada', function () {
        Order::factory()->count(10)->create(['restaurant_id' => $this->restaurant->id]);

        $this->withToken($this->token)
            ->getJson("/api/restaurants/{$this->restaurant->id}/orders?per_page=5")
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonPath('meta.per_page', 5);
    });

    it('exibe pedido existente', function () {
        $order = Order::factory()
            ->has(OrderItem::factory()->count(2), 'items')
            ->create();

        $this->withToken($this->token)
            ->getJson("/api/orders/{$order->id}")
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'restaurant', 'items', 'total', 'status']);
    });

    it('retorna 404 ao exibir pedido inexistente', function () {
        $this->withToken($this->token)
            ->getJson('/api/orders/999999')
            ->assertStatus(404)
            ->assertJson(['message' => 'Recurso não encontrado']);
    });

    it('atualiza status do pedido', function () {
        $order = Order::factory()->create();

        $this->withToken($this->token)
            ->patchJson("/api/orders/{$order->id}/status", [
                'status' => OrderStatus::PREPARING,
            ])
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'restaurant', 'items', 'total', 'status']);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => OrderStatus::PREPARING->value,
        ]);
    });

    it('retorna 422 ao atualizar status do pedido com dados inválidos', function () {
        $order = Order::factory()->create();

        $this->withToken($this->token)
            ->patchJson("/api/orders/{$order->id}/status", [
                'status' => 'preparando',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    });

    it('retorna 404 ao atualizar status de um pedido inexistente', function () {
        $this->withToken($this->token)
            ->patchJson('/api/orders/999999/status', [
                'status' => OrderStatus::PREPARING,
            ])
            ->assertStatus(404)
            ->assertJson(['message' => 'Recurso não encontrado']);
    });
});
