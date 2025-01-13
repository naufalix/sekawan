<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminHome;
use App\Http\Controllers\Approver\ApproverHome;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// AUTH
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// ADMIN PAGE
Route::group(['prefix'=> 'admin','middleware'=>['auth:admin']], function(){
    Route::get('/', [AdminHome::class, 'index']);
    Route::get('/admin', [AdminAdmin::class, 'index']);
    Route::get('/shop', [AdminShop::class, 'index']);
    
    Route::post('/admin', [AdminAdmin::class, 'postHandler']);
    Route::post('/shop', [AdminShop::class, 'postHandler']);
});

// OWNERS PAGE
Route::group(['prefix'=> 'approver','middleware'=>['auth:approver  ']], function(){
    Route::get('/', [ApproverDashboard::class, 'index']);
    Route::get('/cashier', [ShopCashier::class, 'index']);
    Route::get('/product', [ShopProduct::class, 'index']);
    Route::get('/profile', [ShopProfile::class, 'index']);
    Route::get('/report', [ShopReport::class, 'index']);
    
    Route::post('/cashier', [ShopCashier::class, 'postHandler']);
    Route::post('/product', [ShopProduct::class, 'postHandler']);
    Route::post('/profile', [ShopProfile::class, 'postHandler']);
    Route::post('/report', [ShopReport::class, 'postHandler']);
});

// API
Route::get('/api/posts', [APIController::class, 'posts']);
Route::get('/api/admin/{admin:id}', [APIController::class, 'admin']);
Route::get('/api/cashier/{cashier:id}', [APIController::class, 'cashier']);
Route::get('/api/product/{product:id}', [APIController::class, 'product']);
Route::get('/api/shop/{shop:id}', [APIController::class, 'shop']);
