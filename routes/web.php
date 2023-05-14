<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');



Route::get('/', [ProductController::class, 'showLatestProducts'])->name('home');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product_id}', [CartController::class, 'addToCart'])->name('cart.add')->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::delete('/cart/{product_id}', [CartController::class, 'removeProduct'])->name('cart.remove');
Route::get('shop', [HomeController::class, 'shopview'])->name('shop');
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');;
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/order',  [OrderController::class, 'store'])->name('order.store');




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
   
});

Route::resource('products',ProductController::class);
Route::resource('cart',CartController::class)->middleware('auth');
