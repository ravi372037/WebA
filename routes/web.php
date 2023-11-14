<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest'])->group( function () {
Route::get('/', [HomeController::class,'index'])->name('index');
Route::get('register', [AuthController::class,'register'])->name('register');
Route::post('register-customer', [AuthController::class, 'registerCustomer'])->name('registerCustomer');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login_auth', [AuthController::class, 'login_auth'])->name('login_auth');
});

//Admin Route
Route::prefix('admin')->middleware(['auth','rolecheck:admin'])->group( function () {
    Route::get('dashboard',[AdminController::class,'index'])->name('admin');
    Route::get('change_status/{status}/{id}',[AdminController::class,'change_status'])->name('change_status');
    Route::post('update_customer',[AdminController::class,'update_customer'])->name('update_customer');
});

//Customer Route
Route::prefix('customer')->middleware(['auth','rolecheck:customer'])->group(function () {
    Route::get('dashboard',[CustomerController::class,'index'])->name('customer');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});
