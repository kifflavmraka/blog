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


// Authentication Routes
//Auth::routes();
Route::get(     'auth/login',             'Auth\LoginController@showLoginForm');
Route::post(    'auth/login',            ['uses' => 'Auth\LoginController@login',     'as' => 'login']);
Route::post(    'auth/logout',            'Auth\LoginController@logout');

// RegistrationRoutes
Route::get(     'auth/register',          'Auth\RegisterController@showRegistrationForm');
Route::post(    'auth/register',          'Auth\RegisterController@register');

// Password Reset routes
Route::get(     'password/reset',         'Auth\ResetPasswordController@showLinkRequestForm')->name('password.request');
Route::post(    'password/email',         'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get(     'password/reset/{token?}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post(    'password/reset',         'Auth\ResetPasswordController@reset')->name('password.reset');


// Categories
Route::resource('categories',             'CategoryController', ['except' => ['create']]);

// Tags
Route::resource('tags',                   'TagController', ['except' => ['create']]);

// Comments
Route::post(    'comments/{post_id}',    ['uses' => 'CommentsController@store',      'as' => 'comments.store'] );
Route::get(     'comments/{id}/edit',    ['uses' => 'CommentsController@edit',       'as' => 'comments.edit']);
Route::put(     'comments/{id}/update',  ['uses' => 'CommentsController@update',     'as' => 'comments.update']);
Route::delete(  'comments/{id}',         ['uses' => 'CommentsController@destroy',    'as' => 'comments.destroy']);
Route::get(     'comments/{id}/delete',  ['uses' => 'CommentsController@delete',      'as' => 'comments.delete']);

//----------------------------------------------------------------------------------------------------------------------

Route::get(     'blog/{slug}',           ['uses' => 'BlogController@getSingle',      'as' => 'blog.single'])->where('slug', '[\w]+');
Route::get(     'blog',                  ['uses' => 'BlogController@getIndex',       'as' => 'blog.index']);
Route::get(     '/',                     ['uses' => 'PagesController@getIndex',      'as' =>'home'] );
Route::get(     'about',                 ['uses' => 'PagesController@getAbout',      'as' => 'about']);

Route::get(     'contact',               ['uses' => 'PagesController@getContact',    'as' => 'contact']);
Route::post(    'contact',               ['uses' => 'PagesController@postContact',   'as' => 'contact']);

Route::resource('posts',                  'PostController');


// Illuminate/Auth/Console/MakeAuthCommand.php edited -> HomeController Changed to Pages Controller on line 55