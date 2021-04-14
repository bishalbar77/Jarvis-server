<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login-otp', 'API\ApiController@login_otp');
Route::post('/registeration-otp', 'API\ApiController@registeration_otp');
Route::post('/files-upload', 'API\ApiController@files_upload');
Route::post('/uid-store', 'API\ApiController@uid_store');
Route::get('/uid-show/{id}', 'API\ApiController@uid_show');
Route::get('/uid-list', 'API\ApiController@uid_list');
Route::get('/uid-delete/{id}', 'API\ApiController@uid_delete');
Route::post('/get-address', 'API\ApiController@get_address');

Route::group([
	'prefix' => 'auth'
], function () {
	Route::post('login', 'AuthController@login');
	Route::post('register', 'AuthController@register');
	Route::group([
		'middleware' => 'auth:api'
	], function() {
		Route::get('logout', 'AuthController@logout');
		Route::get('user', 'AuthController@user');
	});
});

Route::get('/api/v1/users', 'APIController@users')->name('api.users.index');