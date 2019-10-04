<?php

use Illuminate\Http\Request;

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
Route::get('/change-password', 'ChangePasswordController@index')->name('password.change');
Route::post('/change-password', 'ChangePasswordController@changePassword')->name('password.update');
Route::post('/reset-password', 'UserController@resetPassword')->name('password.reset');

//management
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('/', 'ManageController@index')->name('admin.manage');
    Route::get('/userlist', 'RegisteredUsersController@index')->name('admin.userlist');
    Route::get('/added-user', 'AddedUserController@index')->name('admin.addedUser');
    Route::get('/reset-password', 'ResetPasswordController@index')->name('admin.resetpassword');
    Route::get('/spotlist', 'SpotlightsListController@index')->name('admin.spotlist');
    Route::get('/log', 'EventLoggerController@index')->name('admin.log');
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

//oauth
Route::get('/oauth', function (Request $request) {
    $request->session()->put('state', $state = Str::random(40));

    $query = http_build_query([
        'client_id' => env('CLIENT_ID'),
        'redirect_uri' => 'http://spotlights.team/callback',
        'response_type' => 'code',
        'scope' => '',
        'state' => $state,
    ]);

    return redirect('http://osu.ppy.sh/oauth/authorize?'.$query);
})->name('oauth');

Route::get('/callback', function (Request $request) {
    $state = $request->session()->pull('state');

    throw_unless(
        strlen($state) > 0 && $state === $request->state,
        InvalidArgumentException::class
    );

    $http = new GuzzleHttp\Client;

    $response = $http->post('http://osu.ppy.sh/oauth/token', [  
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'redirect_uri' => 'http://spotlights.team/callback',
            'code' => $request->code,
        ],
    ]);

    $data = json_decode((string) $response->getBody(), true);

    $token = $data['access_token'];

    $user = $http->request('GET', 'https://osu.ppy.sh/api/v2/me', [
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ],
    ]);

    return json_decode((string) $user->getBody(), true);
});
