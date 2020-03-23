<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Client;

class ClientsController extends Controller {

    public function show($username) {

        $client = Client::where('username',$username)->first();

        if($client != null) {
            return response()->json($client,200);
        } else {
            return response()->json([],404);
        }

    }

    public function store(Request $request) {

        $this->validate($request, [
            'username' => 'required|string|unique:clients',
            'password' => 'required|string|min:6',
            'display_name' => 'required|string',
            'nation' => 'sometimes|string',
            'city' => 'sometimes|string'
        ]);

        $validated = $request->only(['username','display_name']);
        $validated['points'] = 0;
        $validated['seconds'] = 0;
        $validated['password'] = app('hash')->make($request->input('password'));

        if($request->has('nation')) {
            $validated['nation'] = $request->input('nation');
        } else {
            $validated['nation'] = 'Deutschland';
        }

        if($request->has('city')) {
            $validated['city'] = $request->input('city');
        } else {
            $validated['city'] = 'Berlin';
        }

        $client = Client::create($validated);

        return response()->json($client, 201);

    }

}
