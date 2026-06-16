<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

describe('Testes de Funcionalidade - Autenticação', function () {
    it('acessar uma rota protegida sem token', function () {
        $this->getJson('/api/restaurants')
            ->assertStatus(401)
            ->assertJson(['message' => 'Não autenticado']);
    });

    it('acessar uma rota protegida com token inválido', function () {
        $this->withHeaders(['Authorization' => 'Bearer token_invalido'])
            ->getJson('/api/restaurants')
            ->assertStatus(401)
            ->assertJson(['message' => 'Não autenticado']);
    });

    it('login com credenciais válidas', function () {
        $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ])->assertStatus(200)
            ->assertJsonStructure(['token']);
    });

    it('login com credenciais inválidas', function () {
        $this->postJson('/api/login', [
            'email' => 'email_invalido@email.com',
            'password' => 'senha_invalida',
        ])->assertStatus(401)
            ->assertJson(['message' => 'Credenciais inválidas']);
    });

    it('registrar um usuário com dados válidos', function () {
        $this->postJson('/api/register', [
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => 'password',
        ])->assertStatus(201)
            ->assertJsonStructure(['token']);
    });

    it('registrar um usuário com dados inválidos', function () {
        $this->postJson('/api/register', [
            'name' => 'Adm',
            'email' => 'Adm',
            'password' => 'Adm',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    });

    it('logout', function () {
        $token = $this->user->createToken('test')->plainTextToken;

        $this->withToken($token)->postJson('/api/logout')
            ->assertStatus(200)
            ->assertJson(['message' => 'Logout realizado com sucesso']);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $this->user->id,
        ]);
    });
});
