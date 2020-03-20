<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Client;

class ClientsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowClient()
    {

        $user = factory('App\Client')->create();

        $response = $this->call('GET', '/users/'.$user->username);
        $this->assertObjectHasAttribute('points',$response->getData());
        $this->assertObjectHasAttribute('seconds',$response->getData());
        $this->assertObjectHasAttribute('display_name',$response->getData());
        $this->assertObjectHasAttribute('username',$response->getData());

        $user->delete();

    }

    public function testStoreClient() {
        $this->json('POST', '/users', ['username' => 'johndoe', 'display_name' => 'John Doe'])
             ->seeJson([
                'username' => 'johndoe',
                'display_name' => 'John Doe',
                'points' => 0,
                'seconds' => 0
             ]);

        Client::where('username','johndoe')->delete();
    }

}
