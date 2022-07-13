<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ManageDepartmentController;
use App\Http\Resources\UserResource;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user/ability', function (Request $request) {
        if($request->user()->tokenCan('system:admin')) {
            return 'user is admin';
        } elseif($request->user()->tokenCan('system:owner')) {
            return 'user is owner';
        } elseif($request->user()->tokenCan('system:user')) {
            return 'user is user';
        } else {
            return 'user has no ability';
        }
    });

    Route::middleware('CheckRole:admin')->group(function () {
        Route::resource('company', CompanyController::class)->except('update');
    });

    Route::middleware('CheckRole:owner')->group(function () {
        Route::resource('company', CompanyController::class)->only('update');
        Route::resource('department', DepartmentController::class)->only('store');
        Route::post('/department/{department}/user/{user}', [ManageDepartmentController::class, 'assignUser']);
        Route::delete('/department/{department}/user/{user}', [ManageDepartmentController::class, 'assignUser']);
        Route::delete('/department/{department}/project/{project}', [ManageDepartmentController::class, 'assignProject']);
        Route::post('/department/{department}/project/{project}', [ManageDepartmentController::class, 'assignProject']);
        Route::resource('projects', ProjectController::class);
    });
    
    Route::middleware('CheckRole:user')->group(function () {
        // Route::resource('company', CompanyController::class);
    });    
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
