<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'auth:api'], function() {

    Route::resource('company-signatories', 'Api\CompanySignatoriesApiController')->except([
        'create', 'edit'
    ]);

    Route::resource('locations','Api\LocationsApiController')->except([
        'create','edit'
    ]);

    // Fetch near bank
    Route::get('/companies-near-branch/{company}','CompaniesController@getCompanyNearBranch');

    //Signatories API
    Route::get('assigned-signatories/{company}','CompaniesController@getCompanyAssignedSignatories');

});
