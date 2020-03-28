<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Client;
use Carbon\Carbon;

class LeaderboardTest extends TestCase {

    public function testLeaderboardController() {
        $this->assertTrue(class_exists(App\Http\Controllers\LeaderboardController::class));
        $this->assertTrue(method_exists(App\Http\Controllers\LeaderboardController::class, 'show'));
        $this->assertTrue(method_exists(App\Http\Controllers\LeaderboardController::class, 'showByNation'));
    }

    public function testLeaderboardShow() {
        factory('App\Client',100)->create([ 'password' => $this->clientPasswordHash ]);
        $response = $this->call('GET', '/leaderboard');
        $this->assertEquals($response->getStatusCode(), 200);
        $responseData = $response->getData();
        $page = $responseData->data;
        $this->assertCount(20,$page);
        for($i = 0; $i < count($page)-1; $i++) {
            $this->assertTrue($page[$i]->points >= $page[$i+1]->points);
        }
        $clients = Client::all();
        foreach($clients as $client) {
            $client->delete();
        }
    }

    public function testLeaderboardShowByNation() {
        $nationToTest = 'de'; //client factory creates random nations: de, es, it
        factory('App\Client',100)->create([ 'password' => $this->clientPasswordHash ]); //hundred clients will make sure, that there's at least one page of the nationToTest available
        $response = $this->call('GET', '/leaderboard/nation/'.$nationToTest);
        $this->assertEquals($response->getStatusCode(), 200);
        $responseData = $response->getData();
        $page = $responseData->data;
        $this->assertCount(20,$page);
        for($i = 0; $i < count($page)-1; $i++) {
            $this->assertTrue($page[$i]->points >= $page[$i+1]->points);
            $this->assertTrue($page[$i]->nation == $nationToTest);
        }
        $clients = Client::all();
        foreach($clients as $client) {
            $client->delete();
        }
    }

}
