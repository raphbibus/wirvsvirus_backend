<?php

namespace App\Http\Controllers;

class StatsController extends Controller
{

    public function show($username) {

        return response()->json([
            'seconds' => rand(1,3000000),
            'points' => rand(0,50000),
        ]);

    }

}
