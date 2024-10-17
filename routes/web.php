<?php

use App\Http\Controllers\FeatureController;
use App\Http\Controllers\SliderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['prefix'=>'slider'] , function(){
    Route::get('/' , [SliderController::class , 'index'])->name('slider.index');
    Route::get('/trash' , [SliderController::class , 'trash'])->name('slider.trash');
    Route::get('/create' , [SliderController::class , 'create'])->name('slider.create');
    Route::post('/store' , [SliderController::class , 'store'])->name('slider.store');
    Route::get('/{slider}/edit' , [SliderController::class , 'edit'])->name('slider.edit');
    Route::get('/{slider}/restore' , [SliderController::class , 'restore'])->name('slider.restore');
    Route::put('/{slider}/update' , [SliderController::class , 'update'])->name('slider.update');
    Route::delete('/{slider}' , [SliderController::class , 'destroy'])->name('slider.destroy');
});
Route::group(['prefix'=>'feature'] , function(){
    Route::get('/' , [FeatureController::class , 'index'])->name('feature.index');
    Route::get('/create' , [FeatureController::class , 'create'])->name('feature.create');
    Route::post('/store' , [FeatureController::class , 'store'])->name('feature.store');
    Route::get('/{feature}/edit' , [FeatureController::class , 'edit'])->name('feature.edit');
    Route::put('/{feature}/update' , [FeatureController::class , 'update'])->name('feature.update');
    Route::delete('/{feature}' , [FeatureController::class , 'destroy'])->name('feature.destroy');
});