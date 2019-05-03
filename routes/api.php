<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'auth'], function ($router) {
    // Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
    Route::get('/posts', 'AuthController@posts');
    Route::post('/posts', 'AuthController@create');
    // Route::post('/logout', 'AuthController@logout');
    // Route::post('/refresh', 'AuthController@refresh');
    // Route::post('/me', 'AuthController@me');
});
