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
    //----------------Admin register-----------------//
    route::resource('MasterMaindata','UserController');

    route::resource('MasterAnalysis','AnalysController');
    Route::get('/Analysis/edit/{type}/{id}/{fdate}/{tdate}/{branch}/{status}', 'AnalysController@edit')->name('Analysis.edit');
    Route::patch('/Analysis/update/{id}/{type}', 'AnalysController@update')->name('Analysis.update');
    Route::delete('/Analysis/delete/{id}/{type}', 'AnalysController@destroy')->name('Analysis.destroy');
    Route::get('/Analysis/deleteImageAll/{id}/{path}', 'AnalysController@deleteImageAll');
    Route::get('/Analysis/deleteImageEach/{type}/{id}/{fdate}/{tdate}/{branch}/{status}/{path}', 'AnalysController@deleteImageEach')->name('deleteImageEach');
    Route::get('/Analysis/destroyImage/{id}/{type}/{fdate}/{tdate}/{branch}/{status}/{path}', 'AnalysController@destroyImage');

    Route::get('/Analysis/Report/{id}/{type}', 'ReportAnalysController@ReportPDFIndex');
    Route::get('/Analysis/ReportDueDate/{type}', 'ReportAnalysController@ReportDueDate');

    //------------------งานการเงิน---------------------//
    route::resource('MasterTreasury','TreasController');
    Route::get('/Treasury/Home/{type}', 'TreasController@index')->name('treasury');
    Route::get('/Treasury/SearchData/{type}/{id}', 'TreasController@SearchData')->name('SearchData');
    Route::get('/Treasury/ReportDueDate/{type}', 'TreasController@ReportDueDate')->name('treasury.ReportDueDate');

    //------------------งานบัญชี----------------------//
    Route::get('/Account/Home/{type}', 'AccountController@index')->name('Accounting');

    //------------------งานประกันภัย----------------------//
    route::resource('MasterInsure','InsureController');
    Route::get('/Insure/Home/{type}', 'InsureController@index')->name('Insure');

    //------------------งานทะเบียน--------------------//
    route::resource('MasterRegis','RegisController');
    Route::get('/Regis/Home/{type}', 'RegisController@index')->name('Regis');

    //------------------ลูกค้า walkin------------------//
    route::resource('MasterDataCustomer','DataCustomerController');
    Route::get('/DataCustomer/Home/{type}', 'DataCustomerController@index')->name('DataCustomer');
    Route::get('/DataCustomer/Savestatus/{value}/{id}', 'DataCustomerController@savestatus')->name('DataCustomer.savestatus');

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
