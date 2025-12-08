<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth:sanctum'], function () {
    Route::get('', [DashboardController::class, 'index'])->name('main');
});
Route::group(['prefix' => 'product', 'middleware' => 'auth:sanctum'], function () {
    Route::get('refrigerator', 'ProductController@index');
    Route::get('washmashine', [ProductController::class, 'washmashine']);

    Route::get('tv32', 'ProductController@tv32');
    Route::get('tv40', 'ProductController@tv40');
    Route::get('tv50', 'ProductController@tv50');
    Route::get('smart', [ProductController::class, 'smart']);
    Route::get('laptop', [ProductController::class, 'laptop']);
    Route::get('vacuum', [ProductController::class, 'vacuum']);
    Route::get('robot', 'ProductController@robotVacum');
    Route::get('vertical-vacum', 'ProductController@verticalVacuum');
    Route::get('favorite', [ProductController::class, 'favorite']);
    Route::get('sales', 'ProductController@sales');
    Route::get('changes', 'ProductController@changes');
    Route::post('set-learn', [ProductController::class, 'learn'])->name('product.learn');
    Route::post('set-favorite', [ProductController::class, 'setFavorite'])->name('product.set-favorite');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('products.detail');
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('products.update');
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
