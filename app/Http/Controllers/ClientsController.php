<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Client;


class ClientsController extends Controller
{

    public function show($username) {

        return response()->json(Client::where('username',$username)->first());

    }

    public function store(Request $request) {

        $this->validate($request, [
            'username' => 'required|unique:clients',
            'display_name' => 'required'
        ]);

        $validated = $request->only(['username','display_name']);
        $validated['points'] = 0;
        $validated['seconds'] = 0;

        $client = Client::create($validated);

        return response()->json($client);

    }

}
