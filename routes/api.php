<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CustomerController;

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\EmployeesController;

// Auth Routes
Route::post('/login', [AuthController::class, 'login']);

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index']);


// User Routes
Route::get('/user', [UserController::class, 'index']);
Route::post('/user', [UserController::class, 'store']);
Route::post('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);
Route::get('/user/search', [UserController::class, 'search']);


// Customer Routes  
Route::get('/customer', [CustomerController::class, 'index']);
Route::post('/customer', [CustomerController::class, 'store']);
Route::post('/customer/{id}', [CustomerController::class, 'update']);
Route::delete('/customer/{id}', [CustomerController::class, 'destroy']);
Route::get('customer/search', [CustomerController::class, 'search']);

Route::get('/employees', [EmployeesController::class, 'index']);
Route::post('/employees', [EmployeesController::class, 'store']);
Route::post('/employees/{id}', [EmployeesController::class, 'update']);
Route::delete('/employees/{id}', [EmployeesController::class, 'destroy']);
Route::get('/employees/search', [EmployeesController::class, 'search']);