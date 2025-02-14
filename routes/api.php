<?php

use App\Http\Controllers\ContractsController;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\SitesController;
use App\Http\Controllers\VendorsController;
use App\Models\Contracts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * route "/register"
 * @method "POST"
 */
Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');

/**
 * route "/login"
 * @method "POST"
 */
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');

/**
 * route "/user"
 * @method "GET"
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:api')->group(function () {
    // Route::get('/phonebook', [PhonebookController::class, 'index']);
});

Route::apiResource('devices', DevicesController::class);
Route::apiResource('vendors', VendorsController::class);
Route::apiResource('contracts', ContractsController::class);
Route::apiResource('employees', EmployeesController::class);
Route::apiResource('sites', SitesController::class);




/**
 * route "/logout"
 * @method "POST"
 */
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');
