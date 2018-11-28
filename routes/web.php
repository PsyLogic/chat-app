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

Route::get('/', 'HomeController@index');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::view('/chat', 'chat')->name('chat-home');
Route::get('/contacts', 'ContactController@get')->name('contact-list');
Route::get('/conversation/{id}', 'MessageController@getMessagesFor')->name('get-message');
Route::post('/message/send', 'MessageController@sendMessage')->name('send-message');
Route::post('/conversation/update-unread-messages', 'MessageController@updateUnreadMessages')->name('update-unread');

