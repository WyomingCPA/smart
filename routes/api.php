<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'data',], function () {
	Route::post('/parce-product', [ProductController::class, 'saveParceProduct']);
});