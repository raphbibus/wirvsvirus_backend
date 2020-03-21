<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Client;


class ClientsController extends Controller
{

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
            'username' => 'required|unique:clients',
            'display_name' => 'required'
        ]);

        $validated = $request->only(['username','display_name']);
        $validated['points'] = 0;
        $validated['seconds'] = 0;

        $client = Client::create($validated);

        return response()->json($client, 201);

    }

}
