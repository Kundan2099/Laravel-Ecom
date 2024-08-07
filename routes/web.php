<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Web\FrontController;
use App\Http\Controllers\Web\ShopController;
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

Route::get('/', function () {
    return view('welcome');
})->name('view.welcome');

// Route::get('/index', function () {
//     return view('web.pages.index');
// });

Route::get('/index', [FrontController::class, 'index']);

Route::get('/shop/{categorySlug?}/{subCategorySlug?}', [ShopController::class, 'viewShop'])->name('web.view.shop');