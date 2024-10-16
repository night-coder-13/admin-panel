<?php

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