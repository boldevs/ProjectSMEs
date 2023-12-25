<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\SupplyerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products', [ProductController::class, 'index']);
Route::post('products', [ProductController::class, 'store']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::put('products/{id}/edit', [ProductController::class, 'update']);
Route::delete('products/{id}/delete', [ProductController::class, 'destroy']);

Route::get('vendors', [VendorController::class, 'index']);
Route::post('vendors', [VendorController::class, 'store']);
Route::get('/vendors/search', [VendorController::class, 'search']);
Route::get('vendors/{id}', [VendorController::class, 'show']);
Route::put('vendors/{id}/edit', [VendorController::class, 'update']);
Route::delete('vendors/{id}/delete', [VendorController::class, 'destroy']);

Route::get('items', [ItemController::class, 'index']);
Route::post('items', [ItemController::class, 'store']);
Route::get('items/{id}', [ItemController::class, 'show']);
Route::put('items/{id}/edit', [ItemController::class, 'update']);
Route::delete('items/{id}/delete', [ItemController::class, 'destroy']);

Route::get('customers', [CustomerController::class, 'index']);
Route::post('customers', [CustomerController::class, 'store']);
Route::get('/customers/search', [CustomerController::class, 'search']);
Route::get('customers/{id}', [CustomerController::class, 'show']);
Route::put('customers/{id}/edit', [CustomerController::class, 'update']);
Route::delete('customers/{id}/delete', [CustomerController::class, 'destroy']);

Route::get('supplyers', [SupplyerController::class, 'index']);
Route::post('supplyers', [SupplyerController::class, 'store']);
Route::get('supplyers/{id}', [SupplyerController::class, 'show']);
Route::put('supplyers/{id}/edit', [SupplyerController::class, 'update']);
Route::delete('supplyers/{id}/delete', [SupplyerController::class, 'destroy']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/search', [CategoryController::class, 'search']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);




