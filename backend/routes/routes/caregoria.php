<?php

use Illuminate\Support\Facades\Route;

$router->group(['prefix' => '/categoria'], function () use ($router){
   $router->get('/get', 'CategoriaController@get');
});