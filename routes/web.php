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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('dashboard/')->middleware('auth')->group(function () {
    Route::get('categories/deleted', [\App\Http\Controllers\CategoryController::class, 'showDeletedCategories'])->name('categories.deleted');
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::post('update-categories/{id}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('update-categories');
    Route::patch('categories/{category}/restore', [\App\Http\Controllers\CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/{category}/force-delete', [\App\Http\Controllers\CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

    Route::get('products/deleted', [\App\Http\Controllers\ProductController::class, 'showDeletedProducts'])->name('products.deleted');
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::post('update-products/{id}', [\App\Http\Controllers\ProductController::class, 'update'])->name('update-products');
    Route::patch('products/{product}/restore', [\App\Http\Controllers\ProductController::class, 'restore'])->name('products.restore');
    Route::delete('products/{product}/force-delete', [\App\Http\Controllers\ProductController::class, 'forceDelete'])->name('products.forceDelete');

    Route::get('locations/deleted', [\App\Http\Controllers\LocationController::class, 'showDeletedLocations'])->name('locations.deleted');
    Route::resource('locations', \App\Http\Controllers\LocationController::class);
    Route::post('update-locations/{id}', [\App\Http\Controllers\LocationController::class, 'update'])->name('update-locations');
    Route::patch('locations/{location}/restore', [\App\Http\Controllers\LocationController::class, 'restore'])->name('locations.restore');
    Route::delete('locations/{location}/force-delete', [\App\Http\Controllers\LocationController::class, 'forceDelete'])->name('locations.forceDelete');

    Route::get('inventories/deleted', [\App\Http\Controllers\InventoryController::class, 'showDeletedInventories'])->name('inventories.deleted');
    Route::resource('inventories', \App\Http\Controllers\InventoryController::class);
    Route::post('update-inventories/{id}', [\App\Http\Controllers\InventoryController::class, 'update'])->name('update-inventories');
    Route::patch('inventories/{inventory}/restore', [\App\Http\Controllers\InventoryController::class, 'restore'])->name('inventories.restore');
    Route::delete('inventories/{inventory}/force-delete', [\App\Http\Controllers\InventoryController::class, 'forceDelete'])->name('inventories.forceDelete');

    Route::get('transactions/deleted', [\App\Http\Controllers\TransactionController::class, 'showDeletedTransactions'])->name('transactions.deleted');
    Route::resource('transactions', \App\Http\Controllers\TransactionController::class);
    Route::post('update-transactions/{id}', [\App\Http\Controllers\TransactionController::class, 'update'])->name('update-transactions');
    Route::patch('transactions/{transaction}/restore', [\App\Http\Controllers\TransactionController::class, 'restore'])->name('transactions.restore');
    Route::delete('transactions/{transaction}/force-delete', [\App\Http\Controllers\TransactionController::class, 'forceDelete'])->name('transactions.forceDelete');


    Route::resource('contact-supports', \App\Http\Controllers\ContactSupportController::class);

});

