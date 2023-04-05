<?php

use App\Http\Controllers\BuilderController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
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

Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::controller(BuilderController::class)->prefix('/builder')->group(function () {
        Route::get('/', 'index')->name('builder.index');
        Route::get('/create', 'create')->name('builder.create');
        Route::get('/{project}', 'show')->name('builder.show');
        Route::get('/{project}/edit', 'edit')->name('builder.edit');


    });
});

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('projects', ProjectController::class);
        Route::resource('videos', VideoController::class);
        Route::resource('users', UserController::class);
        Route::resource('interactions', InteractionController::class);
    });
