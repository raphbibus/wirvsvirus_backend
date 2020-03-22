<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Client;

class ClientsTest extends TestCase {

    public function testClientsControllerAndModel() {
        $this->assertTrue(class_exists(App\Http\Controllers\ClientsController::class));
        $this->assertTrue(class_exists(App\Client::class));
        $this->assertTrue(method_exists(App\Http\Controllers\ClientsController::class, 'show'));
        $this->assertTrue(method_exists(App\Http\Controllers\ClientsController::class, 'store'));
    }

    public function testShowClient() {
        $client = factory('App\Client')->create();
        $response = $this->call('GET', '/users/'.$client->username);
        $this->assertObjectHasAttribute('points',$response->getData());
        $this->assertObjectHasAttribute('seconds',$response->getData());
        $this->assertObjectHasAttribute('display_name',$response->getData());
        $this->assertObjectHasAttribute('username',$response->getData());
        $this->assertObjectHasAttribute('nation',$response->getData());
        $this->assertObjectHasAttribute('city',$response->getData());
        $this->assertEquals($response->getStatusCode(), 200);
        $client->delete();
    }

    public function testShowClientDoesNotExist() {
        $client = factory('App\Client')->make();
        $response = $this->call('GET', '/users/'.$client->username);
        $this->assertEquals($response->getStatusCode(), 404);
    }

    public function testStoreClient() {
        $response = $this->call('POST', '/users', ['username' => 'johndoe', 'display_name' => 'John Doe', 'nation' => 'it', 'city' => 'Rom']);
        $this->assertObjectHasAttribute('points',$response->getData());
        $this->assertObjectHasAttribute('seconds',$response->getData());
        $this->assertObjectHasAttribute('display_name',$response->getData());
        $this->assertObjectHasAttribute('username',$response->getData());
        $this->assertObjectHasAttribute('created_at',$response->getData());
        $this->assertObjectHasAttribute('updated_at',$response->getData());
        $this->assertObjectHasAttribute('nation',$response->getData());
        $this->assertObjectHasAttribute('city',$response->getData());
        $client = $response->getData();
        $this->assertTrue($client->username == 'johndoe');
        $this->assertTrue($client->display_name == 'John Doe');
        $this->assertTrue($client->points == 0);
        $this->assertTrue($client->seconds == 0);
        $this->assertTrue($client->nation == 'it');
        $this->assertTrue($client->city == 'Rom');
        $this->assertEquals($response->getStatusCode(), 201);
        Client::where('username','johndoe')->delete();
    }

    public function testStoreClientExists() {
        $this->call('POST', '/users', ['username' => 'johndoe', 'display_name' => 'John Doe']);
        $response = $this->call('POST', '/users', ['username' => 'johndoe', 'display_name' => 'John Doe']);
        $this->assertEquals($response->getStatusCode(), 422);
    }

}
