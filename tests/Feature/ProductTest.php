<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('test')->plainTextToken;
    $this->restaurant = Restaurant::factory()->create();
    $this->category = Category::factory()->create(['restaurant_id' => $this->restaurant->id]);
});

describe('Testes de Funcionalidade - Produtos', function () {
    it('cria produto em categoria existente', function () {
        $this->withToken($this->token)
            ->postJson("/api/categories/{$this->category->id}/products", [
                'name' => 'X-Burguer Clássico',
                'price' => 24.90,
                'description' => 'Pão brioche, blend 150g, queijo cheddar e molho especial',
                'is_available' => true,
            ])
            ->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'price', 'description', 'is_available', 'category']);

        $this->assertDatabaseHas('products', [
            'category_id' => $this->category->id,
            'name' => 'X-Burguer Clássico',
            'price' => 24.90,
        ]);
    });

    it('retorna 422 ao criar produto com dados inválidos', function () {
        $this->withToken($this->token)
            ->postJson("/api/categories/{$this->category->id}/products", [
                'name' => str_repeat('a', 256),
                'price' => -1,
                'description' => 'Pão brioche, blend 150g, queijo cheddar e molho especial',
                'is_available' => 123,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'price', 'is_available']);
    });

    it('retorna 404 ao criar produto em categoria existente', function () {
        $this->withToken($this->token)
            ->postJson('/api/categories/999999/products', [
                'name' => 'X-Burguer Clássico',
                'price' => 24.90,
                'description' => 'Pão brioche, blend 150g, queijo cheddar e molho especial',
                'is_available' => true,
            ])
            ->assertStatus(404)
            ->assertJson(['message' => 'Recurso não encontrado']);
    });

    it('retorna 422 ao criar produto com nome duplicado na mesma categoria', function () {
        $product = Product::factory()->create(['category_id' => $this->category->id]);

        $this->withToken($this->token)
            ->postJson("/api/categories/{$this->category->id}/products", [
                'name' => $product->name,
                'price' => 24.90,
                'description' => 'Pão brioche, blend 150g, queijo cheddar e molho especial',
                'is_available' => true,
            ])
            ->assertStatus(422)
            ->assertJson(['message' => 'Este produto já está cadastrado nesta categoria']);
    });

    it('lista produtos de forma paginada', function () {
        Product::factory()->count(10)->create(['category_id' => $this->category->id]);

        $this->withToken($this->token)
            ->getJson("/api/categories/{$this->category->id}/products?per_page=5")
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonPath('meta.per_page', 5);
    });

    it('exibe produto existente', function () {
        $product = Product::factory()->create();

        $this->withToken($this->token)
            ->getJson("/api/products/$product->id")
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'name', 'price', 'description', 'is_available', 'category']);
    });

    it('retorna 404 ao exibir produto inexistente', function () {
        $this->withToken($this->token)
            ->getJson('/api/products/999999')
            ->assertStatus(404)
            ->assertJson(['message' => 'Recurso não encontrado']);
    });

    it('atualiza produto com dados válidos', function () {
        $product = Product::factory()->create();

        $this->withToken($this->token)
            ->patchJson("/api/products/$product->id", [
                'name' => 'Nome do produto após alterações',
                'price' => 34.90,
                'description' => 'Descrição da categoria após alterações',
                'is_available' => false,
            ])
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'name', 'price', 'description', 'is_available', 'category']);

        $this->assertDatabaseHas('products', [
            'name' => 'Nome do produto após alterações',
            'price' => 34.90,
        ]);
    });

    it('retorna 404 ao atualizar produto inexistente', function () {
        $this->withToken($this->token)
            ->putJson('/api/products/999999', [
                'name' => 'Nome do produto após alterações',
                'price' => 34.90,
                'description' => 'Descrição da categoria após alterações',
                'is_available' => false,
            ])
            ->assertStatus(404)
            ->assertJson(['message' => 'Recurso não encontrado']);
    });

    it('deleta produto existente', function () {
        $product = Product::factory()->create();

        $this->withToken($this->token)
            ->deleteJson("/api/products/$product->id")
            ->assertStatus(204);

        $this->assertSoftDeleted('products', [
            'name' => $product->name,
        ]);
    });

    it('retorna 404 ao deletar produto inexistente', function () {
        $this->withToken($this->token)
            ->deleteJson('/api/products/999999')
            ->assertStatus(404)
            ->assertJson(['message' => 'Recurso não encontrado']);
    });

});
