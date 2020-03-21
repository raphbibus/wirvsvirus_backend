<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Client;
use Carbon\Carbon;

class LeaderboardTest extends TestCase
{

    public function testLeaderboardController() {
        $this->assertTrue(class_exists(App\Http\Controllers\LeaderboardController::class));
        $this->assertTrue(method_exists(App\Http\Controllers\LeaderboardController::class, 'show'));
        factory('App\Client',55)->create();
        $response = $this->call('GET', '/leaderboard');
        $this->assertEquals($response->getStatusCode(), 200);
        $responseData = $response->getData();
        $page = $responseData->data;
        $this->assertCount(20,$page);
        $clients = Client::all();
        foreach($clients as $client) {
            $client->delete();
        }
    }

}
