<?php

use App\Http\Controllers\Api\AuthController;
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
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->withTrashed();
        Route::post('/restore/{id}', [UserController::class, 'restore'])->withTrashed();
        Route::get('/users/archives', [UserController::class, 'archives']);
        Route::patch('/update/{id}', [UserController::class, 'update']);
    });


});

Route::get('/unauthorized', function () {
    return response([
        'status' => 'error',
        'message' => 'Unauthorized'
    ], 404);
})->name('unauthorized');

Route::get('/getUser/{role_id}', [UserController::class, 'getUser']);

Route::get('/', [UserController::class, 'index']);

Route::post('/login', [AuthController::class, 'login']);