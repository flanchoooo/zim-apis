<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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


$router->group(['prefix' => 'api/v1'], function ($app) {
    $app->get('validation/zim-national-id/{id}', 'ValidationsController@zimbabweNationalIdValidation');

    //Hits
    $app->get('hits-statistics', 'HitsController@getHits');
    $app->get('balance/{id}', 'ZamtelController@balance');
    $app->get('topup/{id}/{amount}', 'ZamtelController@topup');
    $app->get('reversal/{id}', 'ZamtelController@reversal');
    $app->get('transactions', 'ZamtelController@transaction');

});
