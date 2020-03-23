<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class AuthController extends ClientsController
{
    public function login(Request $request)
    {

    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|username|unique:clients',
            'password' => 'required',
            'display_name' => 'required',
            'nation' => 'nullable|string',
            'city' => 'nullable|string',
        ]);
    }
}
