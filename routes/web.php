<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Persons api endpoints
 */
Route::get('/api/persons', 'Api\PersonController@index');
Route::post('/api/persons', 'Api\PersonController@store');
Route::put('/api/persons/{person}', 'Api\PersonController@update');
Route::delete('/api/persons/{person}', 'Api\PersonController@destroy');
Route::patch('/api/persons/{person}/avatar', 'Api\AvatarController@update');
