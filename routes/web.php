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
    return redirect('/home');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function()
  {
    //------------------Admin--------------------//
    Route::get('/maindata/register', 'UserController@register')->name('regist');
    Route::post('/maindata/saveregister', 'UserController@Saveregister')->name('Saveregist');
    Route::get('/maindata/view', 'UserController@index')->name('ViewMaindata');
    Route::get('/maindata/edit/{id}', 'UserController@edit')->name('maindata.edit');
    Route::patch('/maindata/update/{id}', 'UserController@update')->name('maindata.update');
    Route::delete('/maindata/delete/{id}', 'UserController@destroy')->name('maindata.destroy');

    route::resource('MasterAnalysis','AnalysController');
    Route::get('/Analysis/Home/{type}', 'AnalysController@index')->name('Analysis');
    Route::get('/Analysis/edit/{type}/{id}/{fdate}/{tdate}/{branch}/{status}', 'AnalysController@edit')->name('Analysis.edit');
    Route::patch('/Analysis/update/{id}/{type}', 'AnalysController@update')->name('Analysis.update');
    Route::delete('/Analysis/delete/{id}/{type}', 'AnalysController@destroy')->name('Analysis.destroy');
    Route::get('/Analysis/deleteImageAll/{id}/{path}', 'AnalysController@deleteImageAll');
    Route::get('/Analysis/deleteImageEach/{type}/{id}/{fdate}/{tdate}/{branch}/{status}/{path}', 'AnalysController@deleteImageEach')->name('deleteImageEach');
    Route::get('/Analysis/destroyImage/{id}/{type}/{fdate}/{tdate}/{branch}/{status}/{path}', 'AnalysController@destroyImage');

    Route::get('/Analysis/Report/{id}/{type}', 'ReportAnalysController@ReportPDFIndex');
    Route::get('/Analysis/ReportDueDate/{type}', 'ReportAnalysController@ReportDueDate');
    Route::get('/Analysis/ReportHomecar/{id}/{type}', 'ReportAnalysController@ReportHomecar');

    Route::get('/ExportExcel/{type}', 'ExcelController@excel');

    //------------------งานกฏหมาย--------------------//
    Route::post('/Legislation/store/{id}/{type}', 'LegislationController@store')->name('legislation.store');
    Route::get('/Legislation/Savestore/{Str1}/{Str2}/{Realty}/{type}', 'LegislationController@Savestore')->name('legislation.Savestore');
    Route::get('/Legislation/Home/{type}', 'LegislationController@index')->name('legislation');
    Route::get('/Legislation/edit/{id}/{type}', 'LegislationController@edit')->name('legislation.edit');
    Route::patch('/Legislation/update/{id}/{type}', 'LegislationController@update')->name('legislation.update');
    Route::delete('/Legislation/delete/{id}/{type}', 'LegislationController@destroy')->name('legislation.destroy');
    Route::get('/Updateanalysis/{id}/{type}', 'LegislationController@updateLegislation');
    Route::get('/Legislation/deleteImageAll/{id}', 'LegislationController@deleteImageAll');
    Route::get('/Legislation/Report/{id}/{type}', 'LegislationController@ReportReceipt')->name('legislation.report');

    //------------------งานเร่งรัด----------------------//
    route::resource('MasterPrecipitate','PrecController');
    Route::get('/Precipitate/Home/{type}', 'PrecController@index')->name('Precipitate');
    Route::get('/Precipitate/ReportPrecDue/{Str1}/{Str2}', 'PrecController@ReportPrecDue');
    Route::get('/PrecipitateExcel', 'PrecController@excel');
    Route::get('/Precipitate/edit/{id}/{type}', 'PrecController@edit')->name('Precipitate.edit');
    Route::patch('/Precipitate/update/{id}/{type}', 'PrecController@update')->name('Precipitate.update');
    Route::delete('/Precipitate/delete/{id}/{type}', 'PrecController@destroy')->name('Precipitate.destroy');

    //------------------งานการเงิน---------------------//
    Route::get('/Treasury/Home/{type}', 'TreasController@index')->name('treasury');
    Route::get('/Treasury/SearchData/{type}/{id}', 'TreasController@SearchData')->name('SearchData');
    Route::get('/Treasury/update/{type}/{id}', 'TreasController@updateAnalysis')->name('treasury.updateAnalysis');
    Route::get('/Treasury/ReportDueDate/{type}', 'TreasController@ReportDueDate')->name('treasury.ReportDueDate');

    //------------------งานบัญชี----------------------//
    Route::get('/Account/Home/{type}', 'AccountController@index')->name('Accounting');

    //------------------งานประกันภัย----------------------//
    route::resource('MasterDataCustomer','DataCustomerController');
    Route::get('/Insure/Home/{type}', 'InsureController@index')->name('Insure');
    Route::post('/Insure/save/{type}', 'InsureController@store');
    Route::delete('/Insure/delete/{id}', 'InsureController@destroy');

    //------------------งานทะเบียน--------------------//
    Route::get('/regcar/view/{type}', 'RegcarController@index')->name('regcar');
    Route::get('/regcar/create/{type}', 'RegcarController@create')->name('regcar.create');

    //------------------ลูกค้า walkin------------------//
    route::resource('MasterDataCustomer','DataCustomerController');
    Route::get('/DataCustomer/Home/{type}', 'DataCustomerController@index')->name('DataCustomer');
    Route::get('/DataCustomer/Savestatus/{value}/{id}', 'DataCustomerController@savestatus')->name('DataCustomer.savestatus');
    Route::delete('/DataCustomer/delete/{id}', 'DataCustomerController@destroy');

    //------------------LOCKER เอกสาร---------------------//
    Route::get('/Document/Home/{type}', 'DocumentController@index')->name('document');
    Route::post('/Document/create/{type}', 'DocumentController@store')->name('document.store');
    Route::get('/Document/download/{file}', 'DocumentController@download');
    Route::get('/Document/preview/{id}/{type}', 'DocumentController@edit');
    Route::delete('/Document/delete/{id}', 'DocumentController@destroy');

    //---------------- logout --------------------//
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/{name}', 'HomeController@index')->name('index');

  });
