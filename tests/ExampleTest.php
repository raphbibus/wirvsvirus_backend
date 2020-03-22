<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SetupTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLumenAvailable()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }
}
