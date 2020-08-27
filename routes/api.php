<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//user auth
Route::post('/user/login','AuthController@login');
Route::post('/user/register','AuthController@register');

Route::group(['middleware' => ['auth:api'],'prefix'=>'user'],function(){
    Route::get('/me','AuthController@me');
});

//articles crud
Route::resource('/article','ArticleController')->middleware('auth:api');
//article like and dislike
Route::post('/articles/like/{id}','LikeController@like')->middleware('auth:api');
Route::post('/articles/dislike/{id}','LikeController@dislike')->middleware('auth:api');
//category crud
Route::resource('/category','CategoryController')->middleware('auth:api');
//profile
Route::post('/profile','ProfileController@edit')->middleware('auth:api');
//Search
Route::get('/search/getAll','SearchController@getAll')->middleware('auth:api');
Route::get('/search/suggestions','SearchController@suggestion')->middleware('auth:api');
Route::post('/search','SearchController@index')->middleware('auth:api');
Route::put('/search/promotion/{id}','SearchController@promote')->middleware('auth:api');
Route::put('/search/revoke/{id}','SearchController@revoke')->middleware('auth:api');
//notification
Route::get('/notification','NotificationController@index')->middleware('auth:api');
Route::delete('/notification/{id}','NotificationController@delete')->middleware('auth:api');
//messages
Route::get('/messages/{id}','MessageController@index')->middleware('auth:api');
Route::post('/messages','MessageController@save')->middleware('auth:api');
Route::post('/messages/search','SearchController@searchMessage')->middleware('auth:api');
//Complaints
Route::resource('/complaints','ComplaintController')->middleware('auth:api');
Route::put('/resolve/{id}','ResolveController@resolveToggle')->middleware('auth:api');
//Comments
Route::get('/comments/{id}','CommentController@index')->middleware('auth:api');
Route::post('/comments/{id}','CommentController@save')->middleware('auth:api');
//Calendar
Route::get('/calendar','CalendarController@index');
//Test
Route::get('/test','TestController@test');

