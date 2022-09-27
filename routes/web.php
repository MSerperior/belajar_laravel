<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/hello', [TestController::class, 'index']);









Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'permission:view-dashboard'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'permission:product-list'])->controller(ProductController::class)->group(function(){
    Route::get('/products', 'index')->name('products.index');
});


Route::middleware(['auth', 'permission:product-create'])->controller(ProductController::class)->group(function () {
    Route::get('/products/create', 'create')->name('products.create');
    Route::post('/products', 'store')->name('products.store');
});

Route::middleware(['auth', 'permission:product-edit'])->controller(ProductController::class)->group(function () {
    Route::get('/products/{product}/edit', 'edit')->name('products.edit');
    Route::put('/products/{product}', 'edit')->name('products.update');
});

Route::middleware(['auth', 'permission:product-delete'])->group(function () {
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login','postLogin')->name('login');

    
    Route::get('/logout', 'logout')->name('logout');
});
