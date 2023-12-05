<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::inertia('/', 'Homepage');
Route::resource('categories', \App\Http\Controllers\CategoryController::class);
Route::get('product-list/{sort?}/{direction?}', \App\Http\Controllers\ProductSortListController::class);
