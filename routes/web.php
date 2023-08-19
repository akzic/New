<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// NewController routes
Route::get('/list', [NewController::class, 'showList'])->name('list');
Route::get('/list/search', [NewController::class, 'fetchFilteredProducts'])->name('list.search');
Route::get('/add', [NewController::class, 'showAdd'])->name('add');
Route::get('/detail/{id}', [NewController::class, 'showDetail'])->name('detail');
Route::get('/edit/{id}', [NewController::class, 'showEdit'])->name('edit');
Route::put('/edit/{id}', [NewController::class, 'update'])->name('edit.update'); // changed the name to avoid conflict
Route::post('/store', [NewController::class, 'store'])->name('store');

// products routes 
Route::get('/products', [NewController::class, 'showList'])->name('product.index');
Route::get('/products/{id}', [NewController::class, 'show'])->name('product.show'); // The 'show' method is missing in your controller
Route::delete('/products/{id}', [NewController::class, 'destroy'])->name('product.destroy');
Route::put('/products/{id}', [NewController::class, 'update'])->name('product.update');

// Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('/register', 'Auth\RegisterController@register');

