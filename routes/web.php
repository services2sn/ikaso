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

/** Authentication */
Auth::routes();
Route::namespace('Auth\Account')->name('account.')->group(function() {
    Route::get('account/created', 'ActivationController@created')->name('created');
    Route::get('account/activate/{activationCode}', 'ActivationController@activate')->name('activate');
    Route::get('account/email', 'ReturnActivationLink@showLinkRequestForm')->name('request');
    Route::post('account/email', 'ReturnActivationLink@sendActivationLink')->name('email');
});

/** Users can access in routes below without being authenticated */
Route::get('/', function() {
    return view('welcome');
});

/** Users must be authenticated to access in routes below and its account must be activated */
Route::middleware(['auth', 'account'])->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');
});

