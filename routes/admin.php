<?php

use App\Http\Controllers\Admin\AdminAccessController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
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
    //Admin Login
    Route::get('/login', [LoginController::class, 'viewLogin'])->name('admin.view.login');
    Route::post('/logins', [LoginController::class, 'handleLogin'])->name('admin.handle.login');

    //Admin Forgot-Password
    Route::get('/forgot-password', [LoginController::class, 'viewForgotPassword'])->name('admin.view.forgot.password');
    Route::post('/forgote-password', [LoginController::class, 'handleForgotPassword'])->name('admin.handle.forgot.password');
});

// Protected for middleware
Route::middleware('auth:admin')->group(function () {

    // Route::get('logout', function () {
    //     Auth::logout();
    //     return redirect()->route('admin.view.login');
    // })->name('admin.handle.logout');

    Route::post('/logout', [DashboardController::class, 'logout'])->name('admin.handle.logout');

    Route::get('/dashboard', [DashboardController::class, 'viewDashboard'])->name('admin.view.dashboard');

    Route::prefix('admin-access')->controller(AdminAccessController::class)->group(function () {
        Route::get('/', 'viewAdminAccessList')->name('admin.view.admin.access.list');
        Route::get('/create', 'viewAdminAccessCreate')->name('admin.view.admin.access.create');
        Route::get('/update/{id}', 'viewAdminAccessUpdate')->name('admin.view.admin.access.update');
        Route::post('/create', 'handleAdminAccessCreate')->name('admin.handle.admin.access.create');
        Route::post('/update/{id}', 'handleAdminAccessUpdate')->name('admin.handle.admin.access.update');
        Route::put('/status', 'handleToggleAdminAccessStatus')->name('admin.handle.admin.access.status');
        Route::get('/delete/{id}', 'handleAdminAccessDelete')->name('admin.handle.admin.access.delete');
    });

    Route::prefix('category')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'viewCategoryList')->name('admin.view.category.list');
        Route::get('/create', 'viewCategoryCreate')->name('admin.view.category.create');
        Route::get('/update/{id}', 'viewCategoryUpdate')->name('admin.view.category.update');
        Route::post('/create', 'handleCategoryCreate')->name('admin.handle.category.create');
        Route::post('/update/{id}', 'handleCategoryUpdate')->name('admin.handle.category.update');
        Route::put('/status', 'handleToggleCategoryStatus')->name('admin.handle.category.status');
        Route::get('/delete/{id}', 'handleCategoryDelete')->name('admin.handle.category.delete');
    });

    Route::prefix('sub-category')->controller(SubCategoryController::class)->group(function () {
        Route::get('/', 'viewSubCategoryList')->name('admin.view.subcategory.list');
        Route::get('/create', 'viewSubCategoryCreate')->name('admin.view.subcategory.create');
        Route::get('/update/{id}', 'viewSubCategoryUpdate')->name('admin.view.subcategory.update');
        Route::post('/create', 'handleSubCategoryCreate')->name('admin.handle.subcategory.create');
        Route::post('//update/{id}', 'handleSubCategoryUpdate')->name('admin.handle.subcategory.update');
        Route::put('/status', 'handleToggleSubCategoryStatus')->name('admin.handle.subcategory.status');
        Route::get('/delete/{id}', 'handleSubCategoryDelete')->name('admin.handle.subcategory.delete');
    });

    Route::prefix('brand')->controller(BrandController::class)->group(function() {
        Route::get('/', 'viewBrandList')->name('admin.view.brand.list');
        Route::get('/create', 'viewBrandCreate')->name('admin.view.brand.create');
        Route::get('/update/{id}', 'viewBrandUpdate')->name('admin.view.brand.update');
        Route::post('/create', 'handleBrandCreate')->name('admin.handle.brand.create');
        Route::post('//update/{id}', 'handleBrandUpdate')->name('admin.handle.brand.update');
        Route::put('/status', 'handleToggleBrandStatus')->name('admin.handle.brand.status');
        Route::get('/delete/{id}', 'handleBrandDelete')->name('admin.handle.brand.delete');
    });

    Route::prefix('product')->controller(ProductController::class)->group(function() {
        Route::get('/', 'viewProductList')->name('admin.view.product.list');
        Route::get('/create', 'viewProductCreate')->name('admin.view.product.create');
        Route::get('/update/{id}', 'viewProductUpdate')->name('admin.view.product.update');
        Route::post('/create', 'handleProductCreate')->name('admin.handle.product.create');
        Route::post('//update/{id}', 'handleProductUpdate')->name('admin.handle.product.update');
        Route::put('/status', 'handleToggleProductStatus')->name('admin.handle.product.status');
        Route::get('/delete/{id}', 'handleProductDelete')->name('admin.handle.product.delete');
    });
});
