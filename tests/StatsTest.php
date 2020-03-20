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
    public function testExample()
    {

        $response = $this->call('GET', '/stats');
        $this->assertObjectHasAttribute('points',$response->getData());
        $this->assertObjectHasAttribute('seconds',$response->getData());

    }
}
