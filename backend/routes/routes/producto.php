<?php

use Illuminate\Support\Facades\Route;

$router->group(['prefix' => '/producto'], function () use ($router){
   $router->get('/get', 'ProductoController@get');
   $router->post('/new', 'ProductoController@new');
   $router->put('/update', 'ProductoController@update');
   $router->delete('/delete/{id}', 'ProductoController@delete');
});