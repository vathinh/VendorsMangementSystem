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

Route::get('login', 'AccountController@login')->middleware('checkLogout');
Route::post('login', 'AccountController@checkLogin');
Route::get('logout', 'AccountController@logout');

Route::get('/home', 'HomeController@index')->name('home')->middleware('checkLogin');
Route::get('/', 'HomeController@index')->name('home')->middleware('checkLogin');

Route::prefix('reports')->name('reports')->middleware('checkLogin')->group(function () {
    Route::get('index', 'ReportController@index')->name('.index');
    Route::get('create', 'ReportController@create');
    Route::post('create', 'ReportController@store');
    Route::get('show/{id}', 'ReportController@show');
    Route::get('edit/{id}', 'ReportController@edit');
    Route::post('update', 'ReportController@update');
    Route::get('delete/{id}', 'ReportController@destroy');
    Route::post('days-order', 'ReportController@days-order');
});
Route::get('/days-order','ReportController@days_order');
Route::post('/days-order','ReportController@days_order');
Route::post('/filter-by-date','ReportController@filter_by_date');
Route::post('/dashboard-filter','ReportController@dashboard_filter');

Route::prefix('users')->name('users')->middleware('checkLogin')->group(function () {
    Route::get('index', 'UserController@index')->name('.index');
    Route::get('create', 'UserController@create');
    Route::post('create', 'UserController@store');
    Route::get('show/{id}', 'UserController@show');
    Route::get('edit/{id}', 'UserController@edit');
    Route::post('edit/{id}', 'UserController@update');
    Route::post('update/password/{id}', 'UserController@updatePassword');
    Route::get('delete/{id}', 'UserController@destroy');
});

Route::prefix('products')->name('products')->middleware('checkLogin')->group(function () {
    Route::get('index', 'ProductController@index')->name('.index');
    Route::get('create', 'ProductController@create');
    Route::post('create', 'ProductController@store');
    Route::get('edit/{id}', 'ProductController@edit');
    Route::post('edit/{id}', 'ProductController@update');
    Route::get('delete/{id}', 'ProductController@destroy');
});

Route::prefix('customers')->name('customers')->middleware('checkLogin')->group(function () {
    Route::get('index', 'CustomersController@index')->name('.index');
    Route::get('create', 'CustomersController@create');
    Route::post('create', 'CustomersController@store');
    Route::get('update/{id}', 'CustomersController@edit');
    Route::post('update/{id}', 'CustomersController@update');
    Route::get('delete/{id}', 'CustomersController@destroy');
    Route::get('/checkstatus/{id}', 'CustomersController@checkstatus');
});

Route::prefix('vendors')->name('vendors')->middleware('checkLogin')->group(function () {
    Route::get('index', 'VendorController@index')->name('.index');
    Route::get('create', 'VendorController@create');
    Route::post('create', 'VendorController@store');
    Route::get('edit/{id}', 'VendorController@edit');
    Route::post('edit/{id}', 'VendorController@update');
    Route::get('delete/{id}', 'VendorController@destroy');
    Route::get('/checkstatus/{id}', 'VendorController@checkstatus');
});

Route::prefix('saleorders')->name('saleorders')->middleware('checkLogin')->group(function () {
    Route::get('index', 'SaleOrderController@index')->name('.index');
    Route::get('create', 'SaleOrderController@create');
    Route::post('create', 'SaleOrderController@store');
    Route::get('edit/{id}', 'SaleOrderController@edit');
    Route::post('edit/{id}', 'SaleOrderController@update');
    Route::get('show/{id}', 'SaleOrderController@show');
    Route::get('delete/{id}', 'SaleOrderController@destroy');
});

Route::prefix('purchaseorders')->name('purchaseorders')->middleware('checkLogin')->group(function () {
    Route::get('index', 'PurchaseOrderController@index')->name('.index');
    Route::get('create', 'PurchaseOrderController@create');
    Route::post('create', 'PurchaseOrderController@store');
    Route::get('edit/{id}', 'PurchaseOrderController@edit');
    Route::post('edit/{id}', 'PurchaseOrderController@update');
    Route::get('show/{id}', 'PurchaseOrderController@show');
    Route::get('delete/{id}', 'PurchaseOrderController@destroy');
});

Route::prefix('invoices')->name('invoices')->middleware('checkLogin')->group(function () {
    Route::get('index', 'InvoiceController@index')->name('.index');
    Route::get('create', 'InvoiceController@create');
    Route::post('create', 'InvoiceController@store');
    Route::get('edit/{id}', 'InvoiceController@edit');
    Route::post('edit/{id}', 'InvoiceController@update');
    Route::get('show/{id}', 'InvoiceController@show');
    Route::get('delete/{id}', 'InvoiceController@destroy');
});

Route::prefix('bills')->name('bills')->middleware('checkLogin')->group(function () {
    Route::get('index', 'BillController@index')->name('.index');
    Route::get('create', 'BillController@create');
    Route::post('create', 'BillController@store');
    Route::get('edit/{id}', 'BillController@edit');
    Route::post('edit/{id}', 'BillController@update');
    Route::get('show/{id}', 'BillController@show');
    Route::get('delete/{id}', 'BillController@destroy');
});

Route::prefix('payables')->name('payables')->middleware('checkLogin')->group(function () {
    Route::get('index', 'PayablesController@index')->name('.index');
    Route::get('create', 'PayablesController@create');
    Route::post('create', 'PayablesController@store');
    Route::get('edit/{id}', 'PayablesController@edit');
    Route::post('edit/{id}', 'PayablesController@update');
    Route::get('show/{id}', 'PayablesController@show');
    Route::get('delete/{id}', 'PayablesController@destroy');
});

Route::prefix('receivables')->name('receivables')->middleware('checkLogin')->group(function () {
    Route::get('index', 'ReceivablesController@index')->name('.index');
    Route::get('create', 'ReceivablesController@create');
    Route::post('create', 'ReceivablesController@store');
    Route::get('edit/{id}', 'ReceivablesController@edit');
    Route::post('edit/{id}', 'ReceivablesController@update');
    Route::get('show/{id}', 'ReceivablesController@show');
    Route::get('delete/{id}', 'ReceivablesController@destroy');
});

Route::prefix('imports')->name('imports')->middleware('checkLogin')->group(function () {
    Route::get('index', 'ImportController@index')->name('.index');
    Route::get('create', 'ImportController@create');
    Route::post('create', 'ImportController@store');
    Route::get('edit/{id}', 'ImportController@edit');
    Route::post('edit/{id}', 'ImportController@update');
    Route::get('show/{id}', 'ImportController@show');
    Route::get('delete/{id}', 'ImportController@destroy');
});

Route::prefix('exports')->name('exports')->middleware('checkLogin')->group(function () {
    Route::get('index', 'ExportController@index')->name('.index');
    Route::get('create', 'ExportController@create');
    Route::post('create', 'ExportController@store');
    Route::get('edit/{id}', 'ExportController@edit');
    Route::post('edit/{id}', 'ExportController@update');
    Route::get('show/{id}', 'ExportController@show');
    Route::get('delete/{id}', 'ExportController@destroy');
});
