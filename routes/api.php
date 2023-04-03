<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InteractionController;
use App\Http\Controllers\Api\InteractionVideosController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ProjectUsersController;
use App\Http\Controllers\Api\ProjectVideosController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserProjectsController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\VideoInteractsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('projects', ProjectController::class);

        // Project Videos
        Route::get('/projects/{project}/videos', [
            ProjectVideosController::class,
            'index',
        ])->name('projects.videos.index');
        Route::post('/projects/{project}/videos', [
            ProjectVideosController::class,
            'store',
        ])->name('projects.videos.store');

        // Project Users
        Route::get('/projects/{project}/users', [
            ProjectUsersController::class,
            'index',
        ])->name('projects.users.index');
        Route::post('/projects/{project}/users/{user}', [
            ProjectUsersController::class,
            'store',
        ])->name('projects.users.store');
        Route::delete('/projects/{project}/users/{user}', [
            ProjectUsersController::class,
            'destroy',
        ])->name('projects.users.destroy');

        Route::apiResource('videos', VideoController::class);

        // Video Interacts
        Route::get('/videos/{video}/interacts', [
            VideoInteractsController::class,
            'index',
        ])->name('videos.interacts.index');
        Route::post('/videos/{video}/interacts', [
            VideoInteractsController::class,
            'store',
        ])->name('videos.interacts.store');

        // Video Interact Withs
        Route::get('/videos/{video}/interacts', [
            VideoInteractsController::class,
            'index',
        ])->name('videos.interacts.index');
        Route::post('/videos/{video}/interacts', [
            VideoInteractsController::class,
            'store',
        ])->name('videos.interacts.store');

        Route::apiResource('users', UserController::class);

        // User Projects
        Route::get('/users/{user}/projects', [
            UserProjectsController::class,
            'index',
        ])->name('users.projects.index');
        Route::post('/users/{user}/projects/{project}', [
            UserProjectsController::class,
            'store',
        ])->name('users.projects.store');
        Route::delete('/users/{user}/projects/{project}', [
            UserProjectsController::class,
            'destroy',
        ])->name('users.projects.destroy');

        Route::apiResource('interactions', InteractionController::class);

        // Interaction Videos
        Route::get('/interactions/{interaction}/videos', [
            InteractionVideosController::class,
            'index',
        ])->name('interactions.videos.index');
        Route::post('/interactions/{interaction}/videos', [
            InteractionVideosController::class,
            'store',
        ])->name('interactions.videos.store');

        //Player

    });

Route::get('/player/{project}', [PlayerController::class, 'index'])->name('player');
