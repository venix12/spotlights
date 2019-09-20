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

//user
Route::get('/users/{id}', 'UserProfileController@index')->name('user.profile');

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

//change password
Route::get('/change-password', 'ChangePasswordController@index')->name('password.change');
Route::post('/change-password', 'ChangePasswordController@changePassword')->name('password.update');

//management
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('/', 'ManageController@index')->name('admin.manage');
    Route::get('/userlist', 'RegisteredUsersController@index')->name('admin.userlist');
    Route::get('/added-user', 'AddedUserController@index')->name('admin.addedUser');
    Route::get('/spotlist', 'SpotlightsListController@index')->name('admin.spotlist');
});

//spotlights
Route::group(['prefix' => 'spotlights'], function() {
    Route::get('/', 'SpotlightsController@index')->name('spotlights');
    Route::get('/{id}', 'SpotlightsController@show')->name('spotlights.show');
    Route::post('/{id}/nominate', 'SpotlightsController@nominate')->name('spotlights.nominate');
    Route::post('/remove-nomination', 'SpotlightsNominationController@destroy')->name('spotlights.removeNomination');
    Route::post('/vote', 'SpotlightsNominationVoteController@index')->name('spotlights.vote');
    Route::post('/update-vote', 'SpotlightsNominationVoteController@update')->name('spotlights.updateVote');
});
