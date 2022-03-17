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

/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */
Route::get('/', 'Frontend\HomeController@index');

#register user
Route::get('register', array('uses'=>'Frontend\UserController@create','as' => 'frontend.users.create'));

#login user
Route::get('login', array('uses'=>'Frontend\LoginController@getLogin','as' => 'frontend.login'));
Route::post('login', array('uses' => 'Frontend\LoginController@doLogin', 'as' => 'frontend.login'));
Route::resource('users', 'Frontend\UserController');

// Password Reset Routes...
Route::get('password/reset', array('uses'=>'Frontend\ForgotPasswordController@showLinkRequestForm', 'as'=>'password.email'));
Route::post('password/email', array('uses'=>'Frontend\ForgotPasswordController@sendResetLinkEmail', 'as'=>'password.email'));
Route::get('password/reset/{token}', array('uses'=>'Frontend\ResetPasswordController@showResetForm', 'as'=>'password.reset'));
Route::post('password/reset', array('uses'=>'Frontend\ResetPasswordController@reset', 'as'=>'password.reset'));

//after login
Route::group(array('middleware' => 'auth.user'), function() {
    
    Route::get('dashboard', 'Frontend\DashboardController@index');

    Route::post('dashboard', 'Frontend\DashboardController@store')->name('dashboard.store');

    #logout user
    Route::get('logout', 'Frontend\LoginController@doLogout');

    Route::get('{slug}', 'Frontend\DashboardController@shortenUrl')->name('shorten.url');
    
});