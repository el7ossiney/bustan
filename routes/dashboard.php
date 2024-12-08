<?php

use App\Http\Controllers\Dashboard\CategoryController;
use Illuminate\Support\Facades\Route;
Route::get('/categories/trashed',[CategoryController::class,'trashed'])->name('categories.trashed');
Route::post('/categories/{category}/trashed',[CategoryController::class,'restore'])->name('categories.restore');
Route::delete('/categories/{category}/trashed',[CategoryController::class,'forceDelete'])->name('categories.forcedelete');
Route::resource('categories', CategoryController::class)->middleware('auth');



