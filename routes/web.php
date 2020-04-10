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


Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('isps', 'IspController');
Route::resource('agencies', 'AgencyController');
Route::resource('users', 'UserController');
Route::resource('subscribers', 'SubscriberController');
Route::resource('products', 'ProductController');
Route::resource('plans', 'PlanController');
Route::resource('services', 'ServiceController');
Route::resource('nas', 'NasController');
Route::resource('olts', 'OltController');
Route::resource('tickets', 'TicketController');
Route::resource('inventories','InventoryController');

Route::resource('payments', 'PaymentController');

Route::get('/tickets/{id}/print', 'TicketController@print');
Route::get('/payments/{id}/print', 'PaymentController@printTicket');
Route::get('/payments/{id}/pdf', 'PaymentController@savePdf');
Route::get('/inventories/{id}/print', 'InventoryController@print');
Route::get('/type__a_materials/{id}/print', 'type_A_materialController@print');
Route::get('/radius/check/{username}', 'RadiusController@check');
Route::get('/radius/auth/{username}/{password}', 'RadiusController@auth');
Route::post('/radius/accounting/{username}', 'RadiusController@accounting');

Route::get('/services/{id}/toggle', 'ServiceController@toggle');
Route::get('/services/{id}/disconnect', 'ServiceController@admin_disconnect_user');
