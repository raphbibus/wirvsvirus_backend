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

    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:clients',
            'password' => 'required|string|min:6',
            'display_name' => 'required',
            'nation' => 'nullable|string',
            'city' => 'nullable|string',
        ]);

        try {
            $storeData = ClientService::getClientStoreData($request->all());

            $client = Client::create($storeData);

            return response()->json([
                'client' => $client,
                'message' => 'Created.'
            ], 201);

        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return response()->json([
                'message' => 'Registration Failed.'
            ], 409);
        }
    }
}
