<?php

namespace App\Http\Controllers;

class StatsController extends Controller
{

    public function show($username) {

        $user = factory('App\Client')->make(
            ['username' => $username]
        );

        return response()->json([
            'seconds' => $user->seconds,
            'points' => $user->points,
        ]);

    }

}
