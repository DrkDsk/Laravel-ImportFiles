<?php

use App\Http\Controllers\Api\FilesController;
use App\Http\Controllers\ImporterController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\MediumsController;
use App\Http\Controllers\MediumsGroupsController;
use App\Http\Controllers\OriginsController;
use App\Http\Controllers\GroupsOriginsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('origins/{origin}', [OriginsController::class, 'update']);
Route::get('origins/{origin}', [OriginsController::class, 'show']);
Route::resource('groups.origins', GroupsOriginsController::class)->only('index');

Route::post('mediums/{medium}', [MediumsController::class, 'show'])->name('mediums.show');
Route::resource('mediums.groups', MediumsGroupsController::class)->only(['store']);
Route::post('import', [ImporterController::class, 'store']);

Route::prefix('reports')->group(function () {
    Route::post('/{medium}', [ReportsController::class, 'show'])->name('report.show');
    Route::post('/{medium}/export', [ReportsController::class, 'export'])->name('report.export');
    Route::get('download/{fileExport}', [ReportsController::class, 'download'])->name('report.download');
});

Route::get('mediums/index',[MediumsController::class, 'index']);
Route::resource('companies', CompanyController::class)->only(['store']);
Route::resource('readedFiles', FilesController::class)->only(['index', 'show']);
Route::delete('readedFiles/{id}', [FilesController::class, 'destroy']);
