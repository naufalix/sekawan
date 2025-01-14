<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminHome;
use App\Http\Controllers\Admin\AdminAdmin;
use App\Http\Controllers\Admin\AdminApprover;
use App\Http\Controllers\Admin\AdminDriver;
use App\Http\Controllers\Admin\AdminOffice;
use App\Http\Controllers\Admin\AdminReservation;
use App\Http\Controllers\Admin\AdminVehicle;
use App\Http\Controllers\Approver\ApproverApproval;
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
    Route::get('/approver', [AdminApprover::class, 'index']);
    Route::get('/driver', [AdminDriver::class, 'index']);
    Route::get('/office', [AdminOffice::class, 'index']);
    Route::get('/reservation', [AdminReservation::class, 'index']);
    Route::get('/vehicle', [AdminVehicle::class, 'index']);
    
    Route::post('/admin', [AdminAdmin::class, 'postHandler']);
    Route::post('/approver', [AdminApprover::class, 'postHandler']);
    Route::post('/driver', [AdminDriver::class, 'postHandler']);
    Route::post('/office', [AdminOffice::class, 'postHandler']);
    Route::post('/reservation', [AdminReservation::class, 'postHandler']);
    Route::post('/vehicle', [AdminVehicle::class, 'postHandler']);
});

// APPROVER PAGE
Route::group(['prefix'=> 'approver','middleware'=>['auth:approver']], function(){
    Route::get('/', [ApproverHome::class, 'index']);
    Route::get('/approval', [ApproverApproval::class, 'index']);
    
    Route::post('/approval', [ApproverApproval::class, 'postHandler']);
});

// API
Route::get('/api/posts', [APIController::class, 'posts']);
Route::get('/api/admin/{admin:id}', [APIController::class, 'admin']);
Route::get('/api/approver/{approver:id}', [APIController::class, 'approver']);
Route::get('/api/driver/{driver:id}', [APIController::class, 'driver']);
Route::get('/api/office/{office:id}', [APIController::class, 'office']);
Route::get('/api/reservation/{reservation:id}', [APIController::class, 'reservation']);
Route::get('/api/reservation_approval/{reservation_approval:id}', [APIController::class, 'reservation_approval']);
Route::get('/api/vehicle/{vehicle:id}', [APIController::class, 'vehicle']);
