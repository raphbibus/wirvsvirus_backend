<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Client;

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

    public function testStatsCheckinWrongTimeStampFormat() {
        $client = factory('App\Client')->create();
        $response = $this->call('POST', '/users/'.$client->username.'/home-enter', ['timestamp' => 'shingshong']);
        $this->assertEquals($response->getStatusCode(), 422);
        $client->delete();
    }

    public function testStatsCheckout() {
        $client = factory('App\Client')->create();
        $inOut = factory('App\InOut')->create();
        $clientInOut = Client::findOrFail($inOut->client_id);
        $response = $this->call('POST', '/users/'.$clientInOut->username.'/home-leave', ['token' => $inOut->token, 'timestamp' => '2020-03-21T15:50:22.000000Z']);
        $this->assertObjectHasAttribute('entered',$response->getData());
        $this->assertObjectHasAttribute('left',$response->getData());
        $this->assertEquals($response->getStatusCode(), 201);
        $client->delete();
        $clientInOut->delete();
    }

    public function testStatsCheckoutClientNotExists() {
        $client = factory('App\Client')->make();
        $response = $this->call('POST', '/users/'.$client->username.'/home-leave', ['token' => md5('xyz'), 'timestamp' => '2020-03-21T15:50:22.000000Z']);
        $this->assertEquals($response->getStatusCode(), 404);
    }

    public function testStatsCheckoutTokenNotExists() {
        $client = factory('App\Client')->create();
        $inOut = factory('App\InOut')->make();
        $response = $this->call('POST', '/users/'.$client->username.'/home-leave', ['token' => $inOut->token, 'timestamp' => '2020-03-21T15:50:22.000000Z']);
        $this->assertEquals($response->getStatusCode(), 422);
        $client->delete();
    }

    public function testStatsCheckoutTokenNotFromClient() {
        $clientWithoutToken = factory('App\Client')->create();
        $clientWithToken = factory('App\Client', 1)->create()->each(function ($client) {
            $client->inouts()->save(factory('App\InOut')->make());
        });
        $inOut = $clientWithToken[0]->inouts()->inRandomOrder()->first();
        $response = $this->call('POST', '/users/'.$clientWithoutToken->username.'/home-leave', ['token' => $inOut->token, 'timestamp' => '2020-03-21T15:50:22.000000Z']);
        $this->assertEquals($response->getStatusCode(), 404);
        $clientWithToken[0]->delete();
        $clientWithoutToken->delete();
    }

    public function testStatsCheckoutTokenSizeWrong() {
        $client = factory('App\Client')->create();
        $inOut = factory('App\InOut')->make();
        $response = $this->call('POST', '/users/'.$client->username.'/home-leave', ['token' => 'blabliblubb', 'timestamp' => '2020-03-21T15:50:22.000000Z']);
        $this->assertEquals($response->getStatusCode(), 422);
        $client->delete();
    }

    public function testStatsCheckoutWrongTimeStampFormat() {
        $client = factory('App\Client')->create();
        $inOut = factory('App\InOut')->make();
        $response = $this->call('POST', '/users/'.$client->username.'/home-leave', ['token' => md5('xyz'), 'timestamp' => 'shingshong']);
        $this->assertEquals($response->getStatusCode(), 422);
        $client->delete();
    }

}
