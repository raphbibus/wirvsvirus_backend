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

        // successful response
        $response = $this->call('POST', '/login', ['username' => $client->username, 'password' => $this->clientPassword]);

        $this->assertObjectHasAttribute('token', $response->getData());
        $this->assertObjectHasAttribute('token_type', $response->getData());
        $this->assertObjectHasAttribute('expires_in', $response->getData());
        $this->assertEquals($response->getData()->token_type, 'bearer');
        $this->assertEquals($response->getData()->expires_in, 3600);
        $this->assertGreaterThan(0, strlen($response->getData()->token));
        $this->assertEquals(200, $response->getStatusCode());

        // invalid credentials (password)
        $response = $this->call('POST', '/login', ['username' => $client->username, 'password' => 'invalid']);

        $this->assertObjectHasAttribute('message', $response->getData());
        $this->assertEquals('Invalid username or password.', $response->getData()->message);
        $this->assertEquals(401, $response->getStatusCode());

        // missing username
        $response = $this->call('POST', '/login', ['password' => 'invalid']);
        $this->assertObjectHasAttribute('username', $response->getData());
        $this->assertEquals('The username field is required.', $response->getData()->username[0]);
        $this->assertEquals(422, $response->getStatusCode());

        // missing password
        $response = $this->call('POST', '/login', ['username' => $client->username]);

        $this->assertObjectHasAttribute('password', $response->getData());
        $this->assertEquals('The password field is required.', $response->getData()->password[0]);
        $this->assertEquals(422, $response->getStatusCode());

        $client->delete();
    }
}
