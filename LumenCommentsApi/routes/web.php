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

$router->get('/comments', 'CommentController@index');
$router->post('/comments', 'CommentController@store');
$router->get('/comments/{comment}', 'CommentController@show');
$router->put('/comments/{comment}', 'CommentController@update');
$router->patch('/comments/{comment}', 'CommentController@update');
$router->delete('/comments/{comment}', 'CommentController@destroy');

$router->get('/comments/review/{review_id}', 'CommentController@commentsByReview');
