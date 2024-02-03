<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Auth;
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
Route::post('/topUp', [WalletController::class, 'topUp'])->name('topUp');
Route::post('/withDrawal', [WalletController::class, 'withDrawal'])->name('withDrawal');
Route::delete('/deleteCart/{id}', [TransactionController::class, 'deleteCart'])->name('deleteCart');
Route::post('/addToCart', [TransactionController::class, 'addToCart'])->name('addToCart');
Route::post('/payNow', [TransactionController::class, 'payNow'])->name('payNow');
Route::get('/download/{order_id}', [TransactionController::class, 'download'])->name('download');

Route::post('/accRequest', [WalletController::class, 'accRequest'])->name('accRequest');
Route::post('/topUp1', [WalletController::class, 'topUp1'])->name('topUp1');
Route::post('/withDrawal1', [WalletController::class, 'withDrawal1'])->name('withDrawal1');
Route::get('/download2', [WalletController::class, 'download2'])->name('download2');

Route::post('/product.store', [ProductController::class, 'store'])->name('product.store');
Route::put('/product.update/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product.destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::get('/download1', [TransactionController::class, 'download1'])->name('download1');

Route::post('/store', [UserController::class, 'store'])->name('store');
Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');