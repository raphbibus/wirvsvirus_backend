<?php

namespace App\Http\Controllers;
use App\Client;
use App\InOut;
use Carbon\Carbon;
use Str;
use Illuminate\Http\Request;

class StatsController extends Controller
{

    public function show($username) {

        $client = Client::where('username',$username)->first();

        return response()->json([
            'seconds' => $client->seconds,
            'points' => $client->points,
        ]);

    }

    public function homeEnter(Request $request, $username) {

        $client = Client::where('username',$username)->first();

        if($client != null) {

            $this->validate($request, [
                'timestamp' => 'required|date',
            ]);

            $dt = Carbon::parse($request->input('timestamp'));

            $inOut = new InOut();
            $inOut->entered = $dt->toDateTimeString();
            $inOut->client_id = $client->id;
            $inOut->token = md5($dt->toDateTimeString().$client->username);
            $inOut->save();

            return response()->json($inOut, 201);
        } else {
            return response()->json([], 404);
        }

    }

}
