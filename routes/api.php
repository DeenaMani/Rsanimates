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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('version','App\Http\Controllers\Api\ApiController@version');

Route::post('sent_otp','App\Http\Controllers\Api\ApiController@sent_otp');
Route::post('register','App\Http\Controllers\Api\ApiController@register');
Route::post('save_app_id','App\Http\Controllers\Api\ApiController@save_app_id');


Route::post('login','App\Http\Controllers\Api\ApiController@login');
Route::post('forget_password','App\Http\Controllers\Api\ApiController@forget_password');
Route::post('check_otp','App\Http\Controllers\Api\ApiController@check_otp');
Route::post('new_password','App\Http\Controllers\Api\ApiController@new_password');


Route::post('ads','App\Http\Controllers\Api\ApiController@ads');
Route::post('ads_detail','App\Http\Controllers\Api\ApiController@ads_detail');

Route::post('category','App\Http\Controllers\Api\ApiController@category');
Route::post('subcategory','App\Http\Controllers\Api\ApiController@subcategory');
Route::post('attribute_mutiple','App\Http\Controllers\Api\ApiController@attribute_mutiple');
Route::post('customer','App\Http\Controllers\Api\ApiController@customer');
Route::post('city','App\Http\Controllers\Api\ApiController@city');
Route::post('banner','App\Http\Controllers\Api\ApiController@banner');
Route::post('setting','App\Http\Controllers\Api\ApiController@setting');

Route::post('save_favorite','App\Http\Controllers\Api\ApiController@save_favorite');
Route::post('delete_favorite','App\Http\Controllers\Api\ApiController@delete_favorite');
Route::post('my_favroite','App\Http\Controllers\Api\ApiController@my_favroite');

Route::post('post_ads','App\Http\Controllers\Api\ApiController@post_ads');
Route::post('edit_ads','App\Http\Controllers\Api\ApiController@edit_ads');
Route::post('destroy_ads','App\Http\Controllers\Api\ApiController@destroy_ads');

Route::post('user_ads','App\Http\Controllers\Api\ApiController@user_ads');
Route::post('update_customer','App\Http\Controllers\Api\ApiController@update_customer');
Route::post('update_profile','App\Http\Controllers\Api\ApiController@update_profile');

Route::post('send_message','App\Http\Controllers\Api\ApiController@send_message');
Route::post('chat_list','App\Http\Controllers\Api\ApiController@chat_list');
Route::post('chat_history','App\Http\Controllers\Api\ApiController@chat_history');

Route::post('notification','App\Http\Controllers\Api\ApiController@notification');

Route::post('delete_image','App\Http\Controllers\Api\ApiController@delete_image');


// condition base service type show 1 or 2
Route::post('service_type','App\Http\Controllers\Api\ApiController@service_type');




