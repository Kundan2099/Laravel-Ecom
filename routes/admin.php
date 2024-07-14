<?php

use App\Http\Controllers\Admin\AdminLoginController;
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

    Route::get('/login', [AdminLoginController::class, 'viewLogin'])->name('admin.view.login');
    Route::post('/login', [AdminLoginController::class, 'handleLogin'])->name('handle.login');

});



Route::get('test', function () {
    return 'admin';
});
