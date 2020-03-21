<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('users', 'ClientsController@store');
$router->get('users/{username}', 'ClientsController@show');
$router->get('users/{username}/stats', 'StatsController@show');
$router->post('users/{username}/home-enter', 'StatsController@homeEnter');
$router->post('users/{username}/home-leave', 'StatsController@homeLeave');
$router->get('leaderboard', 'LeaderboardController@show');
