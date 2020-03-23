<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Client;

class AuthTest extends TestCase {
    public function testAuthController() {
        $this->assertTrue(class_exists(App\Http\Controllers\AuthController::class));
        $this->assertTrue(method_exists(App\Http\Controllers\AuthController::class, 'login'));
    }

    public function testLogin() {
        $client = factory('App\Client')->create(['password' => $this->clientPasswordHash]);
        $response = $this->call('POST', '/login', ['username' => $client->username, 'password' => $this->clientPassword]);
        $this->assertObjectHasAttribute('token', $response->getData());
        $this->assertObjectHasAttribute('token_type', $response->getData());
        $this->assertObjectHasAttribute('expires_in', $response->getData());

        $this->assertEquals($response->getData()->token_type, 'bearer');
        $this->assertEquals($response->getData()->expires_in, 3600);
        $this->assertGreaterThan(0, strlen($response->getData()->token));
        Client::where('username', $client->username)->delete();
    }
}
