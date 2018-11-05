<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('api')->group(function () {
    // Auth::routes();
    Route::get('/user', function () {
        return Auth::user();
    });

    Route::resource('sorts', 'SortController')->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);

    Route::resource('songs', 'SongController')->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);
});

Route::get('/play/{url}', 'SongController@play');

Route::get('{any}',  function () {
    return view('home');
})
->where('any', '.*');
