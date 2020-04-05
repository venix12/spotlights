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

Route::get('/login', 'OsuOauthController@getOauthRedirect')->name('login');
Route::post('/login', 'Auth\LoginController@login');

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

//user
Route::get('/users/{id}', 'UserProfileController@index')->name('user.profile');
Route::get('/users-list', 'UserListController@index')->name('user.list');

//admin user
Route::post('/activate-user', 'UserController@activate')->name('admin.activateUser');
Route::post('/deactivate-user', 'UserController@deactivate')->name('admin.deactivateUser');
Route::post('/remove-user', 'UserController@destroy')->name('admin.removeUser');

//admin spotlights
Route::post('/activate-spots', 'SpotlightsController@activate')->name('admin.activateSpotlights');
Route::post('/deactivate-spots', 'SpotlightsController@deactivate')->name('admin.deactivateSpotlights');
Route::post('/remove-spots', 'SpotlightsController@destroy')->name('admin.removeSpotlights');

Route::get('/new-spotlights', 'SpotlightsController@new')->name('admin.newSpotlights');
Route::post('/create-spotlights', 'SpotlightsController@create')->name('admin.createSpotlights');

Route::post('/remove-comment', 'SpotlightsNominationVoteController@removeComment')->name('admin.removeComment');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'ManageController@index')->name('admin.manage');
    Route::get('/log', 'EventLoggerController@index')->name('admin.log');
    Route::get('/spotlist', 'SpotlightsListController@index')->name('admin.spotlist');
    Route::get('/userlist', 'RegisteredUsersController@index')->name('admin.userlist');

    Route::group(['prefix' => 'add-member'], function () {
        Route::get('/', 'AddMemberController@create')->name('admin.add-member');
        Route::post('/', 'AddMemberController@store')->name('admin.add-member.store');
    });

    Route::group(['prefix' => 'app'], function () {
        Route::get('/', 'ApplicationController@create')->name('admin.app');
        Route::post('/{direction}', 'ApplicationController@moveAround')->name('admin.app.move-around');
        Route::post('/delete-revert-question', 'ApplicationController@deleteOrRevertQuestion')->name('admin.app.delete-revert-question');
        Route::post('/store-question', 'ApplicationController@storeQuestion')->name('admin.app.store-question');
    });

    Route::group(['prefix' => 'app-eval'], function () {
        Route::get('/', 'AppEvaluationController@index')->name('admin.app-eval');
        Route::get('/create-cycle', 'AppEvaluationController@createCycle')->name('admin.app-eval.create-cycle');
        Route::get('/deactivate-cycle', 'AppEvaluationController@deactivateCurrentCycle')->name('admin.app-eval.deactivate-current-cycle');
        Route::get('/{id}', 'AppEvaluationController@show')->name('admin.app-eval.show');

        Route::post('/create-cycle', 'AppEvaluationController@storeCycle')->name('admin.app-eval.store');
        Route::post('/{id}/approve-feedback', 'AppEvaluationController@approveFeedback')->name('admin.app-eval.approve-feedback');
        Route::post('/{id}/store-feedback', 'AppEvaluationController@storeFeedback')->name('admin.app-eval.store-feedback');
    });

    Route::group(['prefix' => 'user-groups'], function () {
        Route::get('/', 'UserGroupsController@index')->name('admin.user-groups');
        Route::get('/create', 'UserGroupsController@create')->name('admin.user-groups.create');
        Route::get('/{id}', 'UserGroupsController@show')->name('admin.user-groups.show');

        Route::post('/create-group', 'UserGroupsController@store')->name('admin.user-groups.store');
        Route::post('/{id}/add-member', 'UserGroupsController@addMember')->name('admin.user-groups.add-member');
        Route::post('/{id}/remove-member', 'UserGroupsController@removeMember')->name('admin.user-groups.remove-member');
    });
});

Route::group(['prefix' => 'app'], function () {
    Route::get('/', 'ApplicationController@create')->name('app-form');
    Route::post('/submit', 'ApplicationController@store')->name('app.store');
});

Route::group(['prefix' => 'spotlights'], function() {
    Route::get('/', 'SpotlightsController@index')->name('spotlights');
    Route::get('/{id}', 'SpotlightsController@show')->name('spotlights.show');

    Route::post('/release', 'SpotlightsController@release')->name('spotlights.release');
    Route::post('/remove-nomination', 'SpotlightsNominationsController@destroy')->name('spotlights.removeNomination');
    Route::post('/set-threshold', 'SpotlightsController@setThreshold')->name('spotlights.setThreshold');
    Route::post('/{id}/beatmaps', 'SpotlightsController@beatmaps')->name('spotlights.mapids');
    Route::post('/{id}/nominate', 'SpotlightsNominationsController@store')->name('spotlights.store-nomination');
    Route::post('/{id}/update-vote', 'SpotlightsNominationVoteController@update')->name('spotlights.update-vote');
    Route::post('/{id}/vote', 'SpotlightsNominationVoteController@store')->name('spotlights.store-vote');
});

Route::group(['prefix' => 'spotlights-results'], function() {
    Route::get('/', 'SpotlightsResultsController@index')->name('spotlights-results');
    Route::get('/{id}', 'SpotlightsResultsController@show')->name('spotlights-results.show');
});

//oauth
Route::get('/callback', 'OsuOauthController@handleCallback');
