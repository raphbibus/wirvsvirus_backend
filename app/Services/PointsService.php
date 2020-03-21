<?php

namespace App\Services;
use Carbon\Carbon;
use App\Client;

class PointsService {

    public function __construct() {

    }

    public function updatePointsAndSeconds(Client $client, Carbon $entered, Carbon $left) {
        $client->points = $client->points + $this->calculatePoints($entered,$left);
        $client->seconds = $client->seconds + $entered->diffInSeconds($left);
        $client->save();
        return $client;
    }

    public function calculatePoints(Carbon $entered, Carbon $left) {

        if($left->greaterThan($entered)) {
            $diffInMinutes = $entered->diffInMinutes($left);
            return ($diffInMinutes * config('points.per_minute'))
                + $this->twelveHoursBonus($diffInMinutes)
                + $this->fortyEightHoursBonus($diffInMinutes);
        } else {
            return 0;
        }

    }

    private function twelveHoursBonus($diffInMinutes) {
        $times = $diffInMinutes / 720;
        if($times >= 1) {
            return config('points.bonus.12_hours') * round($times);
        }
        return 0;
    }

    private function fortyEightHoursBonus($diffInMinutes) {
        $times = $diffInMinutes / 2880;
        if($times >= 1) {
            return config('points.bonus.48_hours') * round($times);
        }
        return 0;
    }

}
