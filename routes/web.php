<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\DrugTransactionController;
use App\Http\Controllers\FormRequestController;
use App\Http\Controllers\ReportController;

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

Route::controller(AuthController::class)->group(function (){
    Route::get('/', 'index');
    Route::post('login', 'postLogin')->name('login');
});

Route::middleware(['authCheck'])->group(function () {
    Route::controller(AuthController::class)->group(function (){
        Route::get('home', 'home')->name('home');
        Route::post('register', 'postRegistration')->name('register');
        Route::post('logout', 'logout')->name('logout');
        Route::get('users', 'userList')->name('users');
        Route::get('delete_user/{id}', 'destroy')->name('delete_user');

    });

    Route::controller(DrugController::class)->group(function (){
        Route::get('drugs', 'index')->name('drugs');
        Route::post('store_drug', 'store')->name('store_drug');  
        Route::get('delete_drug/{id}', 'destroy')->name('delete_drug');        
    });

    Route::controller(DrugTransactionController::class)->group(function (){
        Route::get('drugs_transaction', 'index')->name('drugs_transaction');
        Route::get('autocomplete_drugs', 'getDrugInfo');
        Route::post('store_drug_transaction', 'store')->name('store_drug_transaction');  
        Route::get('print_receipt/{receipt_no}', 'receiptDispensary');
        Route::get('click_print_receipt/{receipt_no}', function ($receipt_no) {
            return "<script>
                window.open('../print_receipt/$receipt_no','','left=0,top=0,width=500,height=477,toolbar=0,scrollbars=0,status =0');
                window.location = '../drugs_transaction';
            </script>"; 
        });
        Route::get('delete_drug_transaction/{id}', 'destroy')->name('delete_drug_transaction');        
    });

    Route::controller(ReportController::class)->group(function (){
        Route::get('report', 'index')->name('report');
        Route::post('get_report', 'getReport')->name('get_report');    
    });
});

Route::controller(FormRequestController::class)->group(function () {
    // Modal Create Route
    Route::get('create-modal/{id}', 'getCreateModalData');

    // Modal Edit Route
    Route::get('edit-modal/{form}/{id}', 'getEditModalData');

    // Modal view Route
    Route::get('view-modal/{form}/{id}', 'getViewModalData');

    // Modal delete Route
    Route::get('delete-modal/{data}/{id}', 'getDeleteModalData');
});

