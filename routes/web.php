<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/a', function() {

   Artisan::call('cache:clear');
   Artisan::call('config:clear');
   Artisan::call('config:cache');
   Artisan::call('view:clear');

   return "Cleared!";

});
Route::get('/', 'App\Http\Controllers\HomeController@index');
Route::get('contact-us', 'App\Http\Controllers\HomeController@contact');
Route::post('post_contact', 'App\Http\Controllers\HomeController@post_contact');
Route::get('service', 'App\Http\Controllers\HomeController@service');
Route::get('service-list/{slug}', 'App\Http\Controllers\HomeController@service_list');
Route::get('work', 'App\Http\Controllers\HomeController@work');
Route::get('about-us', 'App\Http\Controllers\HomeController@about_us');



Route::get('a/', 'App\Http\Controllers\Admin\AdminController@index');
Route::get('admin/', 'App\Http\Controllers\Admin\AdminController@index');

Route::get('admin/login', 'App\Http\Controllers\Admin\AdminController@login');
Route::post('admin/check_login', 'App\Http\Controllers\Admin\AdminController@check_login')->name('admin.check_login');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('admin/dashboard', 'App\Http\Controllers\Admin\AdminController@dashboard');
Route::match(array('GET','POST'),'admin/profile', 'App\Http\Controllers\Admin\AdminController@profile');
Route::match(array('GET','POST'),'admin/change_password', 'App\Http\Controllers\Admin\AdminController@change_password');

Route::resource('admin/setting', 'App\Http\Controllers\Admin\SettingController');


Route::resource('admin/banner', 'App\Http\Controllers\Admin\BannerController');
Route::get('admin/banner/status/{id}/{status}', 'App\Http\Controllers\Admin\BannerController@status');
Route::resource('admin/futures', 'App\Http\Controllers\Admin\FuturesController');
Route::get('admin/futures/status/{id}/{status}', 'App\Http\Controllers\Admin\FuturesController@status');

Route::resource('admin/service', 'App\Http\Controllers\Admin\ServiceController');
Route::resource('admin/contact', 'App\Http\Controllers\Admin\ContactController');

Route::get('admin/contact/view/{id}', 'App\Http\Controllers\Admin\ContactController@view');

Route::get('admin/service/status/{id}/{status}', 'App\Http\Controllers\Admin\ServiceController@status');

Route::resource('admin/servicelist', 'App\Http\Controllers\Admin\ServicelistController');
Route::get('admin/servicelist/status/{id}/{status}', 'App\Http\Controllers\Admin\ServicelistController@status');

Route::resource('admin/clients', 'App\Http\Controllers\Admin\ClientsController');

Route::get('admin/clients/status/{id}/{status}', 'App\Http\Controllers\Admin\ClientsController@status');

Route::resource('admin/about', 'App\Http\Controllers\Admin\AboutController');
 
Route::resource('admin/profile', 'App\Http\Controllers\Admin\ProfileController');

Route::resource('admin', 'App\Http\Controllers\Admin\AdminController');
Route::get('/destory', 'App\Http\Controllers\Admin\AdminController@destory');

//Clear Cache facade value:
Route::get('/cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/rcache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/rclear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/vclear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
