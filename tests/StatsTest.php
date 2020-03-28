<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Client;

class StatsTest extends TestCase {

    public function testStatsController() {
        $this->assertTrue(class_exists(App\InOut::class));
        $this->assertTrue(class_exists(App\Http\Controllers\StatsController::class));
        $this->assertTrue(method_exists(App\Http\Controllers\StatsController::class, 'show'));
        $this->assertTrue(method_exists(App\Http\Controllers\StatsController::class, 'pointsAdd'));
        $this->assertTrue(method_exists(App\Http\Controllers\StatsController::class, 'homeEnter'));
        $this->assertTrue(method_exists(App\Http\Controllers\StatsController::class, 'homeLeave'));
    }

    public function testShowStats() {
        $client = factory('App\Client')->create(['password' => $this->clientPasswordHash]);
        $response = $this->call('GET', '/users/'.$client->username.'/stats');
        $this->assertObjectHasAttribute('points',$response->getData());
        $this->assertObjectHasAttribute('seconds',$response->getData());
        $this->assertEquals($response->getStatusCode(), 200);
        $client->delete();
    }

    public function testStatsAddPoints() {
        $client = factory('App\Client')->create(['password' => $this->clientPasswordHash]);
        $pointsBefore = $client->points;
        $pointsToAdd = 50;
        $response = $this->call('POST', '/users/'.$client->username.'/points-add', ['points' => $pointsToAdd]);
        $this->assertEquals($response->getStatusCode(), 201);
        $this->assertObjectHasAttribute('points',$response->getData());
        $data = $response->getData();
        $this->assertTrue($data->points == $pointsBefore + $pointsToAdd);
        $client->delete();
    }

    public function testStatsAddPointsClientNotExists() {
        $client = factory('App\Client')->make();
        $response = $this->call('POST', '/users/'.$client->username.'/points-add', ['points' => 50]);
        $this->assertEquals($response->getStatusCode(), 404);
    }

    public function testStatsAddPointsInvalidNumber() {
        $client = factory('App\Client')->create(['password' => $this->clientPasswordHash]);
        $response = $this->call('POST', '/users/'.$client->username.'/points-add', ['points' => 50.2]);
        $this->assertEquals($response->getStatusCode(), 422);
        $client->delete();
    }

    public function testStatsCheckin() {
        $client = factory('App\Client')->create(['password' => $this->clientPasswordHash]);
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
        $client = factory('App\Client')->create(['password' => $this->clientPasswordHash]);
        $response = $this->call('POST', '/users/'.$client->username.'/home-enter', ['timestamp' => 'shingshong']);
        $this->assertEquals($response->getStatusCode(), 422);
        $client->delete();
    }

    public function testStatsCheckout() {
        $client = factory('App\Client')->create(['password' => $this->clientPasswordHash]);
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
        $client = factory('App\Client')->create(['password' => $this->clientPasswordHash]);
        $inOut = factory('App\InOut')->make();
        $response = $this->call('POST', '/users/'.$client->username.'/home-leave', ['token' => $inOut->token, 'timestamp' => '2020-03-21T15:50:22.000000Z']);
        $this->assertEquals($response->getStatusCode(), 422);
        $client->delete();
    }

    public function testStatsCheckoutTokenNotFromClient() {
        $clientWithoutToken = factory('App\Client')->create(['password' => $this->clientPasswordHash]);
        $clientWithToken = factory('App\Client', 1)->create(['password' => $this->clientPasswordHash])->each(function ($client) {
            $client->inouts()->save(factory('App\InOut')->make());
        });
        $inOut = $clientWithToken[0]->inouts()->inRandomOrder()->first();
        $response = $this->call('POST', '/users/'.$clientWithoutToken->username.'/home-leave', ['token' => $inOut->token, 'timestamp' => '2020-03-21T15:50:22.000000Z']);
        $this->assertEquals($response->getStatusCode(), 404);
        $clientWithToken[0]->delete();
        $clientWithoutToken->delete();
    }

    public function testStatsCheckoutTokenSizeWrong() {
        $client = factory('App\Client')->create(['password' => $this->clientPasswordHash]);
        $inOut = factory('App\InOut')->make();
        $response = $this->call('POST', '/users/'.$client->username.'/home-leave', ['token' => 'blabliblubb', 'timestamp' => '2020-03-21T15:50:22.000000Z']);
        $this->assertEquals($response->getStatusCode(), 422);
        $client->delete();
    }

    public function testStatsCheckoutWrongTimeStampFormat() {
        $client = factory('App\Client')->create(['password' => $this->clientPasswordHash]);
        $inOut = factory('App\InOut')->make();
        $response = $this->call('POST', '/users/'.$client->username.'/home-leave', ['token' => md5('xyz'), 'timestamp' => 'shingshong']);
        $this->assertEquals($response->getStatusCode(), 422);
        $client->delete();
    }

}
