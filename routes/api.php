<?php

use App\Http\Controllers\API\ProductCategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// UNTUK MENDAFTARKAN CONTROLLER YANG DIMILIKI

// Route::get('url / nama routing (https://namaweb.com/API/products)', [nama controller::class, 'nama function']);
Route::get('products', [ProductController::class, 'all']);
Route::get('categories', [ProductCategoryController::class, 'all']);

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

// Group route user
Route::middleware('auth:sanctum')->group(function() {
    Route::get('user', [UserController::class, 'fetch']); // Method fetch (Untuk mengambil data user)
    Route::post('user', [UserController::class, 'updateProfile']); // Update profile post
    Route::post('logout', [UserController::class, 'logout']); // Logout and revoked token user

    Route::get('transactions', [TransactionController::class, 'all']); // Transaction
    Route::post('checkout', [TransactionController::class, 'checkout']); // Checkout

});
