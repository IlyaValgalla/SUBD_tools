<?php
use App\Http\Controllers\api\CategoryControllerApi;
use App\Http\Controllers\api\EquipmentControllerApi;
use App\Http\Controllers\api\RentalControllerApi;
use App\Http\Controllers\api\UserControllerApi;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserController;


/////////////// API маршруты  ///////////////////


////// Токен Аунтификация //////////
//    Route::post('/login',[AuthController::class,'login']);
//
//    Route::get('/category', [CategoryControllerApi::class, 'index']);
//    Route::get('/category/{id}', [CategoryControllerApi::class, 'show']);
//
//    Route::get('/equipment', [EquipmentControllerApi::class, 'index']);
//    Route::get('/equipment/{id}', [EquipmentControllerApi::class, 'show']);
//
//    Route::get('/rental', [RentalControllerApi::class, 'index']);
//    Route::get('/rental/{id}', [RentalControllerApi::class, 'show']);
//
//    Route::get('/user', [UserControllerApi::class, 'index']);
//    Route::get('/user/{id}', [UserControllerApi::class, 'show']);
