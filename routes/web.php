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

$router->get('/dashboard', function () use ($router) {
  return file_get_contents('../public/dashboard.html');
});

$router->get('/api/v1/games', 'GamesController@send');
$router->get('/api/v1/totals', 'TotalsController@send');