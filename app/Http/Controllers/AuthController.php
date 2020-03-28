<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use Illuminate\Http\Request;
use App\Client;
use Illuminate\Support\Facades\Auth;

class AuthController extends ClientsController
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['username', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid username or password.'], 401);
        }

        return $this->respondWithToken($token);
    }
}
