<?php

use App\Models\Restaurant;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('test')->plainTextToken;
});

describe('Testes de Funcionalidade - Restaurantes', function () {
    it('cria restaurante', function () {
        $this->withToken($this->token)
            ->postJson('/api/restaurants', [
                'name' => 'Burger House',
                'address' => 'Rua das Flores, 123, Centro, Aracaju - SE',
            ])
            ->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'address']);

        $this->assertDatabaseHas('restaurants', [
            'name' => 'Burger House',
        ]);
    });

    it('retorna 422 ao criar restaurante com dados inválidos', function () {
        $this->withToken($this->token)
            ->postJson('/api/restaurants', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'address']);
    });

    it('lista restaurantes de forma paginada', function () {
        Restaurant::factory()->count(10)->create();

        $this->withToken($this->token)
            ->getJson('/api/restaurants?per_page=5')
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonPath('meta.per_page', 5);
    });

    it('exibe restaurante existente', function () {
        $restaurant = Restaurant::factory()->create();

        $this->withToken($this->token)
            ->getJson("/api/restaurants/$restaurant->id")
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'name', 'address']);
    });

    it('retorna 404 ao exibir restaurante inexistente', function () {
        $this->withToken($this->token)
            ->getJson('/api/restaurants/999999')
            ->assertStatus(404)
            ->assertJson(['message' => 'Recurso não encontrado']);
    });

    it('atualiza restaurante com dados válidos', function () {
        $restaurant = Restaurant::factory()->create();

        $this->withToken($this->token)
            ->putJson("/api/restaurants/$restaurant->id", [
                'name' => 'Nome do restaurante após alterações',
                'address' => 'Endereço do restaurante após alterações',
            ])
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'name', 'address']);

        $this->assertDatabaseHas('restaurants', [
            'name' => 'Nome do restaurante após alterações',
        ]);
    });

    it('retorna 404 ao atualizar restaurante inexistente', function () {
        $this->withToken($this->token)
            ->putJson('/api/restaurants/999999', [
                'name' => 'Nome do restaurante após alterações',
                'address' => 'Endereço do restaurante após alterações',
            ])
            ->assertStatus(404)
            ->assertJson(['message' => 'Recurso não encontrado']);
    });

    it('deleta restaurante existente', function () {
        $restaurant = Restaurant::factory()->create();

        $this->withToken($this->token)
            ->deleteJson("/api/restaurants/$restaurant->id")
            ->assertStatus(204);

        $this->assertSoftDeleted('restaurants', [
            'name' => $restaurant->name,
        ]);
    });

    it('retorna 404 ao deletar restaurante inexistente', function () {
        $this->withToken($this->token)
            ->deleteJson('/api/restaurants/999999')
            ->assertStatus(404)
            ->assertJson(['message' => 'Recurso não encontrado']);
    });
});
