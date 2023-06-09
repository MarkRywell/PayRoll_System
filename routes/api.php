<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PayrollController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\UserController;
use App\Http\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Route::middleware('permission')->get('/role', function (Request $request) {
    // 
// });
// 

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/dashboard', function() {
        return Helper::authDecode(Auth::user());
    });

    Route::group(['middleware' => ['permission']], function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::prefix('users')->group(function () {
            Route::put('/rate/{id}', [UserController::class, 'updateRate']);
            Route::get('/rate/{id}', [UserController::class, 'getRate']);
            Route::delete('/{id}', [UserController::class, 'destroy'])->withTrashed();
            Route::post('/restore/{id}', [UserController::class, 'restore'])->withTrashed();
            Route::get('/archives', [UserController::class, 'archives']);
            Route::put('/{id}', [UserController::class, 'updateUser']);
        });

        Route::prefix('payroll')->group(function () {
            Route::post('/', [PayrollController::class, 'store']);
            Route::get('/', [PayrollController::class, 'index']);
        });
    });

    Route::prefix('salary')->group(function () {
        Route::get('/{id}', [SalaryController::class, 'show']);
        Route::get('/', [SalaryController::class, 'index']);
    });

    Route::prefix('address')->group(function () {
        Route::get('/{id}', [AddressController::class, 'show']);
        Route::post('/', [AddressController::class, 'store']);
    });

    Route::get('/profile/{id}', [UserController::class, 'profile']);
    Route::get('/payroll/{id}', [PayrollController::class, 'show']);
    Route::get('/payroll/latest/{id}', [PayrollController::class, 'showLatest']);
    Route::get('/getUser', [UserController::class, 'getUser']);
    
});

Route::get('/unauthorized', function () {
    return response([
        'status' => 'error',
        'message' => 'Unauthorized'
    ], 404);
})->name('unauthorized');

Route::get('/getPhoto/{photo}', [UserController::class, 'getPhoto']);

Route::get('/', [UserController::class, 'index']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);