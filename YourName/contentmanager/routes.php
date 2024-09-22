// routes.php

<?php
use Illuminate\Support\Facades\Route;

use yourname\contentmanager\Controllers\Registration;

// API route group
Route::group(['prefix' => 'api'], function () {

    // Content API routes
    Route::get('/contents', 'yourname\contentmanager\Controllers\ContentApiController@index');
	Route::get('/contents/{id}', 'yourname\contentmanager\Controllers\ContentApiController@show');
	Route::post('/contents', 'yourname\contentmanager\Controllers\ContentApiController@store');
	Route::put('/contents/{id}', 'yourname\contentmanager\Controllers\ContentApiController@update');
	Route::delete('/contents/{id}', 'yourname\contentmanager\Controllers\ContentApiController@destroy');


    // User API routes
    Route::post('/api/register', 'yourname\contentmanager\Controllers\Registration@register'); // User registration
    Route::post('/login', [UserController::class, 'login']); // User login
    Route::middleware('auth.jwt')->get('/users/{id}', [UserController::class, 'show']);

});

