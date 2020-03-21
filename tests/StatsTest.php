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
}
