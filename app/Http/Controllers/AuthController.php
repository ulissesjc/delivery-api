<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *  path="/api/register",
     *  summary="Registrar usuário",
     *  tags={"Autenticação"},
     *
     *  @OA\RequestBody(
     *      required=true,
     *
     *      @OA\JsonContent(
     *          required={"name", "email", "password"},
     *
     *          @OA\Property(property="name", type="string", example="Admin"),
     *          @OA\Property(property="email", type="string", example="admin@gmail.com"),
     *          @OA\Property(property="password", type="string", example="password")
     *      )
     *  ),
     *
     *  @OA\Response(response=201, description="Usuário registrado com sucesso",
     *
     *      @OA\JsonContent(@OA\Property(property="token", type="string"))
     *  ),
     *
     *  @OA\Response(response=422, description="Erro de validação dos campos"),
     *  @OA\Response(response=500, description="Erro interno no servidor")
     * )
     */
    public function register(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return response()->json([
            'token' => $user->createToken($user->name)->plainTextToken,
        ], 201);
    }

    /**
     * @OA\Post(
     *  path="/api/login",
     *  summary="Login",
     *  tags={"Autenticação"},
     *
     *  @OA\RequestBody(
     *      required=true,
     *
     *      @OA\JsonContent(
     *          required={"email", "password"},
     *
     *          @OA\Property(property="email", type="string", example="admin@gmail.com"),
     *          @OA\Property(property="password", type="string", example="password")
     *      )
     *  ),
     *
     *  @OA\Response(response=200, description="Usuário autenticado com sucesso",
     *
     *      @OA\JsonContent(@OA\Property(property="token", type="string"))
     *  ),
     *
     *  @OA\Response(response=401, description="Credenciais inválidas"),
     *  @OA\Response(response=422, description="Erro de validação dos campos"),
     *  @OA\Response(response=500, description="Erro interno no servidor")
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (! Auth::attempt($request->validated())) {
            return response()->json([
                'message' => 'Credenciais inválidas',
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'token' => $user->createToken($user->name)->plainTextToken,
        ], 200);
    }

    /**
     * @OA\Post(
     *  path="/api/logout",
     *  summary="Logout",
     *  tags={"Autenticação"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\Response(response=200, description="Logout realizado com sucesso",
     *
     *      @OA\JsonContent(@OA\Property(property="message", type="string"))
     *  ),
     *
     *  @OA\Response(response=401, description="Não autenticado")
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso'], 200);
    }
}
