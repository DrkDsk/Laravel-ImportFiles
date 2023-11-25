<?php

use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryServicesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MediumsController;
use App\Http\Controllers\CompanyBrandController;
use App\Http\Controllers\OriginsController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PackageBrandsController;
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
Route::get('/', [DashboardController::class, 'index'])->middleware(['web', 'auth']);

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['web', 'auth']], function () {

    Route::resource('fileExport', ExportController::class)->only(['index', 'show']);
    Route::post('mediums/{medium}', [MediumsController::class, 'show'])->name('mediums.show');
    Route::get('brands/index', [MediumsController::class, 'brands'])->name('contracted.brands.index');
    Route::resource('companies/contract/brand',CompanyBrandController::class)->only(['store']);
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::resource('users', UserController::class)->except(['show', 'destroy']);
    Route::get('reports', [ReportsController::class, 'index'])->name('report.index');
    Route::resource('brands', BrandsController::class)->except(['show']);
    Route::resource('origins', OriginsController::class)->only('show', 'update');
    Route::resource('category', CategoryController::class)->except(['show']);
    Route::resource('category.services', CategoryServicesController::class)->shallow()->except(['show']);
    Route::resource('files', FileController::class)->shallow();
    Route::resource('packages', PackageController::class)->only('index', 'edit', 'create', 'store');
    Route::resource('package.brands', PackageBrandsController::class)->only('create', 'store');

    Route::get('/{medium}', [DashboardController::class, 'show'])->name('medium');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
