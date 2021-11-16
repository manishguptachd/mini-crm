<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

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
    return redirect('/login');
});

Route::get('/register', function() {
    return redirect('/login');
});

Route::post('/register', function() {
    return redirect('/login');
});

Auth::routes([
    'register' => false, // Register Routes...
    // 'reset' => false, // Reset Password Routes...
    // 'verify' => false, // Email Verification Routes...
]);
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Company CRUD
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies');
    Route::post('/create-company', [CompanyController::class, 'create'])->name('create-company');
    Route::delete('/company-delete/{id}', [CompanyController::class, 'destroy'])->name('company-delete');
    Route::get('/company-edit/{id}', [CompanyController::class, 'edit'])->name('company-edit');
    Route::post('/company-update/{id}', [CompanyController::class, 'update'])->name('company-update');

    // Employee CRUD
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
    Route::post('/create-employee', [EmployeeController::class, 'create'])->name('create-employee');
    Route::delete('/employee-delete/{id}', [EmployeeController::class, 'destroy'])->name('employee-delete');
    Route::get('/employee-edit/{id}', [EmployeeController::class, 'edit'])->name('employee-edit');
    Route::post('/employee-update/{id}', [EmployeeController::class, 'update'])->name('employee-update');
});