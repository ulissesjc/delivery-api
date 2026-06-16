<?php

use App\Models\Category;
use App\Models\Restaurant;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('test')->plainTextToken;
    $this->restaurant = Restaurant::factory()->create();
});

describe('Testes de Funcionalidade - Categorias', function () {
    it('cria categoria em restaurante existente', function () {
        $this->withToken($this->token)
            ->postJson("/api/restaurants/{$this->restaurant->id}/categories", [
                'name' => 'Hambúrgueres',
                'description' => 'Artesanais e smash burgers',
            ])
            ->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'description', 'restaurant']);

        $this->assertDatabaseHas('categories', [
            'restaurant_id' => $this->restaurant->id,
            'name' => 'Hambúrgueres',
        ]);
    });

    it('retorna 422 ao criar categoria com dados inválidos', function () {
        $this->withToken($this->token)
            ->postJson("/api/restaurants/{$this->restaurant->id}/categories", [
                'name' => true,
                'description' => str_repeat('a', 256),
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'description']);
    });

    it('retorna 404 ao criar categoria em restaurante inexistente', function () {
        $this->withToken($this->token)
            ->postJson('/api/restaurants/999999/categories', [
                'name' => 'Hambúrgueres',
                'description' => 'Artesanais e smash burgers',
            ])
            ->assertStatus(404)
            ->assertJson(['message' => 'Recurso não encontrado']);
    });

    it('retorna 422 ao criar categoria com nome duplicado no mesmo restaurante', function () {
        $category = Category::factory()->create(['restaurant_id' => $this->restaurant->id]);

        $this->withToken($this->token)
            ->postJson("/api/restaurants/{$category->restaurant_id}/categories", [
                'name' => $category->name,
                'description' => 'Artesanais e smash burgers',
            ])
            ->assertStatus(422)
            ->assertJson(['message' => 'Esta categoria já está cadastrada neste restaurante']);
    });

    it('lista categorias de forma paginada', function () {
        Category::factory()->count(10)->create(['restaurant_id' => $this->restaurant->id]);

        $this->withToken($this->token)
            ->getJson("/api/restaurants/{$this->restaurant->id}/categories?per_page=5")
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonPath('meta.per_page', 5);
    });

    it('exibe categoria existente', function () {
        $category = Category::factory()->create();

        $this->withToken($this->token)
            ->getJson("/api/categories/$category->id")
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'name', 'description', 'restaurant']);
    });

    it('retorna 404 ao exibir categoria inexistente', function () {
        $this->withToken($this->token)
            ->getJson('/api/categories/999999')
            ->assertStatus(404)
            ->assertJson(['message' => 'Recurso não encontrado']);
    });

    it('atualiza categoria com dados válidos', function () {
        $category = Category::factory()->create();

        $this->withToken($this->token)
            ->patchJson("/api/categories/$category->id", [
                'name' => 'Nome da categoria após alterações',
                'description' => 'Descrição da categoria após alterações',
            ])
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'name', 'description', 'restaurant']);

        $this->assertDatabaseHas('categories', [
            'name' => 'Nome da categoria após alterações',
        ]);
    });

    it('retorna 404 ao atualizar categoria inexistente', function () {
        $this->withToken($this->token)
            ->putJson('/api/categories/999999', [
                'name' => 'Nome da categoria após alterações',
                'description' => 'Descrição da categoria após alterações',
            ])
            ->assertStatus(404)
            ->assertJson(['message' => 'Recurso não encontrado']);
    });

    it('deleta categoria existente', function () {
        $category = Category::factory()->create();

        $this->withToken($this->token)
            ->deleteJson("/api/categories/$category->id")
            ->assertStatus(204);

        $this->assertSoftDeleted('categories', [
            'name' => $category->name,
        ]);
    });

    it('retorna 404 ao deletar categoria inexistente', function () {
        $this->withToken($this->token)
            ->deleteJson('/api/categories/999999')
            ->assertStatus(404)
            ->assertJson(['message' => 'Recurso não encontrado']);
    });
});
