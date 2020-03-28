<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $clientPassword = '123456';
    protected $clientPasswordHash;

    protected function setUp(): void
    {
        parent::setUp();

        $this->clientPasswordHash = app('hash')->make($this->clientPassword);
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
