<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest:admin'])->group(function () {

    Route::get('/login', [LoginController::class, 'viewLogin'])->name('admin.view.login');
    Route::post('/logins', [LoginController::class, 'handleLogin'])->name('admin.handle.login');
});

// Protected for middleware
Route::middleware('auth:admin')->group(function () {

    Route::get('logout', function () {
        Auth::logout();
        return redirect()->route('admin.view.login');
    })->name('admin.handle.logout');

    Route::get('/dashboard', [DashboardController::class, 'viewDashboard'])->name('admin.view.dashboard');
});

Route::get('test', function () {
    return 'admin';
});
