<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
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






//PUBLIC ROUTES
    Route::get('/search/{name}', [UserController::class, 'search']);
    // Route::get('/users', [UserController::class, 'index']);


//PROTECTED ROUTES
Route::group(['middleware' => ['auth:sanctum', 'checkActiveTime']], function(){     // 

        
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/update/{id}', [UserController::class, 'update']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::delete('/delete/{id}', [UserController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);


    Route::get('/users', [UserController::class, 'index']);
    Route::get('/checkId', [AuthController::class, 'checkId']);
});


    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

