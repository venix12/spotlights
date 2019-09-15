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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/spotlights', 'SpotlightsController');

Route::post('/deactivate-user', 'UserController@deactivate')->name('admin.deactivateUser');
Route::post('/remove-user', 'UserController@destroy')->name('admin.removeUser');

//change password
Route::get('/change-password', 'ChangePasswordController@index')->name('password.change');
Route::post('/change-password', 'ChangePasswordController@changePassword')->name('password.update');

Route::get('/new-spotlights', 'SpotlightsController@new')->name('admin.newSpotlights');
Route::post('/create-spotlights', 'SpotlightsController@create')->name('admin.createSpotlights');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('/', 'ManageController@index')->name('admin.dashboard');
    Route::get('/userlist', 'RegisteredUsersController@index')->name('admin.userlist');
    Route::get('/added-user', 'AddedUserController@index')->name('addmin.addedUser');
});

Route::group(['prefix' => 'spotlights'], function() {
    Route::get('/', 'SpotlightsController@index')->name('spotlights');
    Route::get('/{id}', 'SpotlightsController@show')->name('spotlights.show');
    Route::post('/{id}/nominate', 'SpotlightsController@nominate')->name('spotlights.nominate');
    Route::post('/remove-nomination', 'SpotlightsNominationController@destroy')->name('spotlights.removeNomination');
    Route::post('/vote', 'SpotlightsNominationVoteController@index')->name('spotlightsVote');
    Route::post('/update-vote', 'SpotlightsNominationVoteController@update')->name('spotlightsUpdateVote');
});
