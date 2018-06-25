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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/forms','FormsController');
Route::get('/forms/generate/{form}','FormsController@generatePDF');

Route::resource('/banks','BanksController');


Route::group(['middleware' => 'auth'], function() {
    Route::resource('/bank-transfers','BankTransfersController');
    Route::get('/bank-transfers/pdf/{x}','BankTransfersController@generatePDF');


    Route::get('/payees','ManagerChecksController@getPayee');
    Route::post('/payees/{user_id}','ManagerChecksController@storePayee');
    Route::put('/payees/{payee}','ManagerChecksController@payeeStatus');
    Route::delete('/payees/{payee}','ManagerChecksController@destroyPayee');

    // Manager check resource
    Route::resource('/manager-checks','ManagerChecksController');
    Route::get('/manager-checks/pdf/{x}','ManagerChecksController@generatePDF');
   



});
