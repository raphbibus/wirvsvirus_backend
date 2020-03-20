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

        $user = factory('App\Client')->make();

        $response = $this->call('GET', '/users/'.$user->username.'/stats');
        $this->assertObjectHasAttribute('points',$response->getData());
        $this->assertObjectHasAttribute('seconds',$response->getData());
        $this->assertObjectHasAttribute('display_name',$response->getData());
        $this->assertObjectHasAttribute('username',$response->getData());

    }
}
