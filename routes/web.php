<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Company\Hr\HrCategoryController;
use App\Http\Controllers\Company\Hr\HrCustomerController;
use App\Http\Controllers\Company\Hr\HrJobTypeController;
use App\Http\Controllers\Company\Hr\HrTypeController;
use App\Http\Controllers\Company\Hr\HrVacancyController;
use App\Http\Controllers\Company\Temple\QrCategoryController as TempleQrCategoryController;
use App\Http\Controllers\Company\Temple\QrItemActivityController;
use App\Http\Controllers\Company\Temple\QrItemController as TempleQrItemController;
use App\Http\Controllers\Company\Temple\QrItemPersonController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Settings\CityController;
use App\Http\Controllers\Settings\CompanyController;
use App\Http\Controllers\Settings\CompanyProductController;
use App\Http\Controllers\Settings\CompanyUsersController;
use App\Http\Controllers\Settings\CountryController;
use App\Http\Controllers\Settings\ProductController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\RegionController;
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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/auth', [AuthController::class, 'authenticate']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LogoutController::class, 'signout']);

    Route::prefix('settings')->group(function () {
        Route::resource('/product', ProductController::class)->except(['show'])->middleware('check.admin');
        Route::resource('/company', CompanyController::class)->middleware('check.admin');
        Route::resource('/company.users', CompanyUsersController::class)->except(['show'])->middleware('check.admin');
        Route::resource('/company.products', CompanyProductController::class)->except(['show'])->middleware('check.admin');
        Route::resource('/country', CountryController::class)->except(['show'])->middleware('check.admin');
        Route::resource('/region', RegionController::class)->except(['show'])->middleware('check.admin');
        Route::get('/city/get-regions', [CityController::class, 'getRegions'])->middleware('check.admin');
        Route::resource('/city', CityController::class)->except(['show'])->middleware('check.admin');

        Route::get('/profile/{id}', [ProfileController::class, 'index']);
        Route::post('/profile/{id}', [ProfileController::class, 'update']);
    });

    Route::prefix('company')->group(function () {
        // HR Section
        Route::prefix('hr')->group(function () {
            Route::resource('/category', HrCategoryController::class)->except(['show']);
            Route::resource('/type', HrTypeController::class)->except(['show']);
            Route::resource('/jobtype', HrJobTypeController::class)->except(['show']);
            Route::resource('/customer', HrCustomerController::class)->except(['show']);
            Route::get('/vacancy/get/regions', [HrVacancyController::class, 'getRegions']);
            Route::get('/vacancy/get/cities', [HrVacancyController::class, 'getCities']);
            Route::resource('/vacancy', HrVacancyController::class)->except(['show']);
        });
        // Temple Section
        Route::prefix('temple')->group(function () {
            Route::resource('/category', TempleQrCategoryController::class)->except(['show']);
            Route::resource('/item', TempleQrItemController::class);
            Route::resource('/item.person', QrItemPersonController::class)->except(['show', 'create', 'edit']);
            Route::resource('/item.activity', QrItemActivityController::class)->except(['show', 'create', 'edit']);
        });
    });

});
