<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        $credentials = $request->all(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return responder()->error(null, 'Usuário ou senha inválida')->respond(422);
        }

        $response = [
            'token' => $token,
            'user' => [
                'id' => auth()->user()->id,
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ]
        ];

        return responder()->success($response)->respond();
    }

    public function logout()
    {
        if (auth()->check()) {
            auth()->logout();

            return responder()->success(['message' => 'Logout realizado com sucesso'])->respond();
        }

        return responder()->error(null,'Usuário não autenticado')->respond(401);
    }

    public function refresh()
    {
        if (auth()->check()) {
            $token = auth()->refresh();

            return responder()->success(compact('token'))->respond();
        }

        return responder()->error(null,'Token inválido')->respond(401);
    }

    public function me()
    {
        if (auth()->check()) {
            $response = [
                'user' => [
                    'id' => auth()->user()->id,
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ]
            ];
            return responder()->success($response)->respond();
        }

        return responder()->error(null,'Usuário não autenticado')->respond(401);
    }

}
