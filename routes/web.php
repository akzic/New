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

Route::get('/list', [NewController::class, 'showList'])->name('list');

Route::get('/add', [NewController::class, 'showAdd'])->name('add');

Route::get('/detail/{id}', [NewController::class, 'showDetail'])->name('detail');

Route::get('/edit/{id}', [NewController::class, 'showEdit'])->name('edit');

Route::put('/edit/{id}', [NewController::class, 'update'])->name('update');

Route::get('/products', [NewController::class, 'showList'])->name('product.index');

Route::get('/products/{id}', [NewController::class, 'show'])->name('product.show');

Route::delete('/products/{id}', [NewController::class, 'destroy'])->name('product.destroy');

Route::put('/products/{id}', [NewController::class, 'update'])->name('product.update');

Route::post('/store', [NewController::class, 'store'])->name('store');

Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');

Route::post('/purchase', [NewController::class, 'purchase'])->name('purchase');
