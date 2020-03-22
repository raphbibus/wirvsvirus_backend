<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Client;


class LeaderboardController extends Controller
{

    public function show(Request $request) {
        $clients = Client::orderBy('points','desc')->paginate(20);
        return response()->json($clients, 200);
    }

    public function showByNation(Request $request, $nation) {
        $clients = Client::where('nation',$nation)->orderBy('points','desc')->paginate(20);
        return response()->json($clients, 200);
    }

}
