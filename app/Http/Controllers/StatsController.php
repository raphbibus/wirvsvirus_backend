<?php

namespace App\Http\Controllers;
use App\Client;
use App\InOut;
use Carbon\Carbon;
use Str;
use Illuminate\Http\Request;
use App\Services\PointsService;

class StatsController extends Controller
{

    public function show($username) {

        $client = Client::where('username',$username)->first();

        return response()->json([
            'seconds' => $client->seconds,
            'points' => $client->points,
        ]);

    }

    public function pointsAdd(Request $request, $username) {

        $client = Client::where('username',$username)->first();

        if($client != null) {

            $this->validate($request, [
                'points' => 'required|integer',
            ]);

            $client->points = $client->points + $request->input('points');
            $client->save();

            return response()->json($client, 201);

        } else {
            return response()->json([], 404);
        }

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
            $inOut->token = md5($dt->toDateTimeString().$client->username.rand(0,10000));
            $inOut->save();

            return response()->json($inOut, 201);
        } else {
            return response()->json([], 404);
        }

    }

    public function homeLeave(Request $request, $username) {

        $client = Client::where('username',$username)->first();

        if($client != null) {

            $this->validate($request, [
                'timestamp' => 'required|date',
                'token' => 'required|exists:inouts,token|size:32'
            ]);

            $inOut = $client->inouts->where('token', $request->input('token'))->where('left', null)->first();

            if($inOut != null) {
                $dtEntered = Carbon::parse($inOut->entered);
                $dtLeft = Carbon::parse($request->input('timestamp'));
                $inOut->left = $dtLeft->toDateTimeString();
                $inOut->save();

                $pointsService = new PointsService();
                $pointsService->updatePointsAndSeconds($client, $dtEntered, $dtLeft);

                return response()->json($inOut, 201);
            } else {
                return response()->json([], 404);
            }

        } else {
            return response()->json([], 404);
        }

    }

}
