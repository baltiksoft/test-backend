<?php

use App\Http\Controllers\AdsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ads - group path
Route::group(['prefix'=>'ads'], function() {
    Route::get('/', [AdsController::class, 'all'])->name('ads.all');
    Route::get('/{ads}', [AdsController::class, 'show'])->name('ads.ads');
    Route::get('/{ads}/fields/{fields}', [AdsController::class, 'show'])->name('ads.ads-fields');
    Route::get('/{offset?}/{limit?}/{sort?}/{type?}', [AdsController::class, 'all'])->name('ads.all-limit');


    Route::post('/', [AdsController::class, 'add'])->name('ads.add');
});
