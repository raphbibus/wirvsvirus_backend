<?php

namespace App\Http\Controllers;
use App\Client;

class StatsController extends Controller
{

    public function show($username) {

        $client = Client::where('username',$username)->first();

        return response()->json([
            'seconds' => $client->seconds,
            'points' => $client->points,
        ]);

    }

}
