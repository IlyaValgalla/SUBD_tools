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
Route::get('/category/create', [CategoryController::class, 'create']);
Route::post('/category', [CategoryController::class, 'store']);
Route::get('/category/edit/{id}', [CategoryController::class, 'edit']);
Route::put('/category/update/{id}', [CategoryController::class, 'update']);
Route::get('/category/destroy/{id}', [CategoryController::class, 'destroy']);
Route::get('/category/{id}', [CategoryController::class, 'show']); //вывод списка инструментов по id категории

Route::get('/equipment', [EquipmentController::class, 'index']); //Список инструментов
Route::get('/equipment/create', [EquipmentController::class, 'create']);// создание инструмента класса
Route::post('/equipment', [EquipmentController::class, 'store']);
Route::get('/equipment/edit/{id}', [EquipmentController::class, 'edit']); //редактирование
Route::put('/equipment/update/{id}', [EquipmentController::class, 'update']); //обновление редактирования инструмента
Route::get('/equipment/destroy/{id}', [EquipmentController::class, 'destroy']); //удаление интсрумента
Route::get('/equipment/{id}', [EquipmentController::class, 'show']);//Вывод списка аренд с этим инструментом


Route::get('/user', [UserController::class, 'index']); //Список пользователей
Route::get('/user/{id}', [UserController::class, 'show']); //Заказ пользователя

Route::get('/rental', [RentalController::class, 'index']); //Список всех инструментов в аренде


