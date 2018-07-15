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
    return view('home');
})->middleware('auth');

Auth::routes();

Route::resource('/forms','FormsController');
Route::get('/forms/generate/{form}','FormsController@generatePDF');

Route::group(['middleware' => 'auth'], function() {

    // Route Setup for PagesController
    Route::get('/home', 'PagesController@index')->name('home');
    Route::get('/master-data', 'PagesController@masterData')->name('master-data');
    Route::get('/recentSubmitted', 'PagesController@recentSubmitted');
    Route::get('/submittedForms', 'PagesController@submittedForms');
    Route::get('/submittedBankTransfer/{date}', 'PagesController@submittedBankTransfer');
    Route::get('/submittedManagerCheck/{date}', 'PagesController@submittedManagerCheck');
    Route::get('/submittedPayroll/{date}', 'PagesController@submittedPayroll');

    // Route Setup of Bank Transfer
    Route::resource('/bank-transfers','BankTransfersController');
    Route::get('/bank-transfers/pdf/{x}','BankTransfersController@generatePDF');

    //Signatories route
    Route::get('/getSignatories','SignatoriesController@getSignatories');
    Route::post('/signatories','SignatoriesController@store');

    // Reoute Setup for bank accounts 
    Route::resource('/accounts','AccountsController');
    Route::get('/getAccounts','AccountsController@getAccounts');

    //Route Setup for bank listing
    Route::resource('/banks','BanksController');
    Route::get('/getBanks','BanksController@getBank');

    // Route Setup for payees - managers check
    Route::get('/payees','ManagerChecksController@getPayee');
    Route::post('/payees/{user_id}','ManagerChecksController@storePayee');
    Route::put('/payees/{payee}','ManagerChecksController@payeeStatus');
    Route::delete('/payees/{payee}','ManagerChecksController@destroyPayee');

    // Manager check resource
    Route::resource('/manager-checks','ManagerChecksController');
    Route::get('/manager-checks/pdf/{x}','ManagerChecksController@generatePDF');

    // Route setup for Branch Manager
    Route::resource('/managers','ManagersController');
    Route::get('/getManagers','ManagersController@getManagers');

    // Route setup for applicant - payroll
    Route::get('/applicants','PayrollsController@getApplicant');
    Route::get('/getPayrollTypes','PayrollsController@getPayrollTypes');
    Route::post('/applicants/{user_id}','PayrollsController@storeApplicant');
    Route::put('/applicants/{applicant}','PayrollsController@statusApplicant');
    Route::delete('/applicants/{applicant}','PayrollsController@destroyApplicant');

    // Company json
    Route::resource('/companies','CompaniesController');
    Route::get('/getCompanies','CompaniesController@getCompanies');

    // Payroll application resource
    Route::resource('/payrolls','PayrollsController');
    Route::get('/payrolls/pdf/{x}','PayrollsController@generatePDF');

    // Get Report API
    Route::get('/reports','ReportController@index');
    Route::get('/getBankTransfer/{date}','ReportController@getBankTransfer');
    Route::get('/getManagerCheck/{date}','ReportController@getManagerCheck');
    Route::get('/getPayroll/{date}','ReportController@getPayroll');

    //Route Setup for User
    Route::resource('/users','UsersController');
    Route::get('/getUsers','UsersController@getUsers');
    Route::get('/getRoles','UsersController@getRoles');
    Route::post('/storeRoles','UsersController@storeRoles');
    Route::patch('/updateRoles/{role}','UsersController@updateRoles');
    Route::get('/getPermissions','UsersController@getPermissions');
    Route::post('/permissions','UsersController@storePermission');

});

Route::any('{any?}', function ($any = null) {
    if (Auth::check()) {
        return redirect('/home');
    } else {
        return redirect('/');
    }
});
