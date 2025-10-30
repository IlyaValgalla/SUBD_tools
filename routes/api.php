<?php
use App\Http\Controllers\api\CategoryControllerApi;
use App\Http\Controllers\api\EquipmentControllerApi;
use App\Http\Controllers\api\RentalControllerApi;
use App\Http\Controllers\api\UserControllerApi;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use http\Client\Request;


/////////////// API маршруты  ///////////////////

    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->get('/category', [CategoryControllerApi::class, 'index']);
    Route::get('/category/{id}', [CategoryControllerApi::class, 'show']);
    Route::get('/categories_total', [CategoryControllerApi::class, 'total']);


        // Просто маршруты equipment
        //    Route::get('/equipment', [EquipmentControllerApi::class, 'index']);
        //    Route::get('/equipment/{id}', [EquipmentControllerApi::class, 'show']);
        //    Route::get('/equipment_total', [EquipmentControllerApi::class, 'total']);

        // защищённые маршруты equipment
        Route::middleware('auth:sanctum')->get('/equipment', [EquipmentControllerApi::class, 'index']);
        Route::middleware('auth:sanctum')->get('/equipment_total', [EquipmentControllerApi::class, 'total']);
        Route::get('/equipment/{id}', [EquipmentControllerApi::class, 'show']);


    Route::get('/rental', [RentalControllerApi::class, 'index']);
    Route::get('/rental/{id}', [RentalControllerApi::class, 'show']);


    Route::middleware('auth:sanctum')->get('/user', [UserControllerApi::class, 'index']);
    //Route::get('/user', [UserControllerApi::class, 'index']);
    Route::get('/user/{id}', [UserControllerApi::class, 'show']);

    Route::middleware('auth:sanctum')->get('/logout', [AuthController::class, 'logout']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/category', [CategoryControllerApi::class, 'index']);
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });

