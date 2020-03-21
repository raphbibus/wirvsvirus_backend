<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class StatsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowStats()
    {

        $client = factory('App\Client')->create();

        $response = $this->call('GET', '/users/'.$client->username.'/stats');
        $this->assertObjectHasAttribute('points',$response->getData());
        $this->assertObjectHasAttribute('seconds',$response->getData());
        $this->assertEquals($response->getStatusCode(), 200);
        $client->delete();

    }

    public function testStatsCheckin() {
        $client = factory('App\Client')->create();
        $response = $this->call('POST', '/users/'.$client->username.'/home-enter', ['timestamp' => '2020-03-21T10:50:22.000000Z']);
        $this->assertEquals($response->getStatusCode(), 201);
        $this->assertObjectHasAttribute('entered',$response->getData());
        $client->delete();
    }

    public function testStatsCheckinClientNotExists() {
        $client = factory('App\Client')->make();
        $response = $this->call('POST', '/users/'.$client->username.'/home-enter', ['timestamp' => '2020-03-21T10:50:22.000000Z']);
        $this->assertEquals($response->getStatusCode(), 404);
    }

    public function testStatsCheckinWrongFormat() {
        $client = factory('App\Client')->create();
        $response = $this->call('POST', '/users/'.$client->username.'/home-enter', ['timestamp' => 'shingshong']);
        $this->assertEquals($response->getStatusCode(), 422);
        $client->delete();
    }


}
