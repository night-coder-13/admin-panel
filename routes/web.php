<?php

use App\Http\Controllers\CategoryController;
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
Route::group(['prefix'=>'category'] , function(){
    Route::get('/' , [CategoryController::class , 'index'])->name('category.index');
    Route::get('/trash' , [CategoryController::class , 'trash'])->name('category.trash');
    Route::get('/create' , [CategoryController::class , 'create'])->name('category.create');
    Route::post('/store' , [CategoryController::class , 'store'])->name('category.store');
    Route::get('/{category}/edit' , [CategoryController::class , 'edit'])->name('category.edit');
    Route::get('/{category}/restore' , [CategoryController::class , 'restore'])->name('category.restore');
    Route::put('/{category}/update' , [CategoryController::class , 'update'])->name('category.update');
    Route::delete('/{category}' , [CategoryController::class , 'destroy'])->name('category.destroy');
});