<?php

namespace App\Http\Controllers;

class StatsController extends Controller
{

    public function show($username) {

        $user = factory('App\Client')->make(
            ['username' => $username]
        );

        return response()->json([
            'display_name' => $user->display_name,
            'seconds' => $user->seconds,
            'points' => $user->points,
            'username' => $user->username,
        ]);

    }

}
