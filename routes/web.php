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
})->name('welcome');

Route::get('/login', 'ApiController@getToken')->name('login');
//Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');

Route::get('/home', 'HomeController@index')->name('home');

//user
Route::get('/users/{id}', 'UserProfileController@index')->name('user.profile');
Route::get('/users-list', 'UserListController@index')->name('user.list');

//admin user
Route::post('/activate-user', 'UserController@activate')->name('admin.activateUser');
Route::post('/change-usergroup', 'UserController@change_usergroup')->name('admin.changeUsergroup');
Route::post('/deactivate-user', 'UserController@deactivate')->name('admin.deactivateUser');
Route::post('/remove-user', 'UserController@destroy')->name('admin.removeUser');

//admin spotlights
Route::post('/activate-spots', 'SpotlightsController@activate')->name('admin.activateSpotlights');
Route::post('/deactivate-spots', 'SpotlightsController@deactivate')->name('admin.deactivateSpotlights');
Route::post('/remove-spots', 'SpotlightsController@destroy')->name('admin.removeSpotlights');

Route::get('/new-spotlights', 'SpotlightsController@new')->name('admin.newSpotlights');
Route::post('/create-spotlights', 'SpotlightsController@create')->name('admin.createSpotlights');

Route::post('/remove-comment', 'SpotlightsNominationVoteController@remove_comment')->name('admin.removeComment');

//password
//Route::get('/change-password', 'ChangePasswordController@index')->name('password.change');
//Route::post('/change-password', 'ChangePasswordController@changePassword')->name('password.update');
Route::post('/reset-password', 'UserController@resetPassword')->name('password.reset');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('/', 'ManageController@index')->name('admin.manage');
    Route::get('/added-user', 'AddedUserController@index')->name('admin.addedUser');
    Route::get('/log', 'EventLoggerController@index')->name('admin.log');
    Route::get('/reset-password', 'ResetPasswordController@index')->name('admin.resetpassword');
    Route::get('/spotlist', 'SpotlightsListController@index')->name('admin.spotlist');
    Route::get('/userlist', 'RegisteredUsersController@index')->name('admin.userlist');
});

Route::group(['prefix' => 'spotlights'], function() {
    Route::get('/', 'SpotlightsController@index')->name('spotlights');
    Route::get('/{id}', 'SpotlightsController@show')->name('spotlights.show');
    Route::post('/{id}/beatmaps', 'SpotlightsController@beatmaps')->name('spotlights.mapids');
    Route::post('/{id}/nominate', 'SpotlightsController@nominate')->name('spotlights.nominate');
    Route::post('/release', 'SpotlightsController@release')->name('spotlights.release');
    Route::post('/remove-nomination', 'SpotlightsNominationController@destroy')->name('spotlights.removeNomination');
    Route::post('/set-threshold', 'SpotlightsController@setThreshold')->name('spotlights.setThreshold');
    Route::post('/vote', 'SpotlightsNominationVoteController@index')->name('spotlights.vote');
    Route::post('/update-vote', 'SpotlightsNominationVoteController@update')->name('spotlights.updateVote');
});

Route::group(['prefix' => 'spotlights-results'], function() {
    Route::get('/', 'SpotlightsResultsController@index')->name('spotlights-results');
    Route::get('/{id}', 'SpotlightsResultsController@show')->name('spotlights-results.show');
});

//oauth
Route::get('/callback', 'ApiController@getUserData');
