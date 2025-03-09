<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello', function () {
    return view('hello', ['title' => 'Hello world!']);
});

Route::get('/category', [CategoryController::class, 'index']); //Список категорий
Route::get('/category/{id}', [CategoryController::class, 'show']); //вывод списка инструментов по id категории

Route::get('/equipment', [EquipmentController::class, 'index']); //Список инструментов
Route::get('/equipment/{id}', [EquipmentController::class, 'show']);//Вывод списка аренд с этим инструментом

Route::get('/user', [UserController::class, 'index']); //Список пользователей
Route::get('/user/{id}', [UserController::class, 'show']); //Заказ пользователя

Route::get('/rental', [RentalController::class, 'index']); //Список всех инструментов в аренде
