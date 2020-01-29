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

// Route::get('/', function () {
//    return view('registration');
// });
Route::get('/', function () {
   return view('login');
});

Route::post('post-login', 'LoginControllerCustom@postLogin'); 
Route::get('registration', 'LoginControllerCustom@registration');
Route::post('post-registration', 'LoginControllerCustom@postRegistration');
Route::get('logout', 'LoginControllerCustom@logout');
// Route::post('email/send','HomeController@send');
Route::match(['post', 'get'], 'email/send', ['as' => 'email/send', 'uses' => 'HomeController@send']);
Route::group(['middleware' => 'revalidate'], function()
{ 
	Route::get('dashboard', 'LoginControllerCustom@dashboard');
	Route::get('dashboard_siswa', 'LoginControllerCustom@dashboard_siswa');  
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
