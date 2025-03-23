<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello', function () {
    return view('hello', ['title' => 'Hello world!']);
});

Route::get('/category', [CategoryController::class, 'index'])->middleware('auth'); //Список категорий
Route::get('/category/create', [CategoryController::class, 'create'])->middleware('auth');
Route::post('/category', [CategoryController::class, 'store'])->middleware('auth');
Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->middleware('auth');
Route::put('/category/update/{id}', [CategoryController::class, 'update'])->middleware('auth');
Route::get('/category/destroy/{id}', [CategoryController::class, 'destroy'])->middleware('auth');
Route::get('/category/{id}', [CategoryController::class, 'show'])->middleware('auth')->name('category.show'); //вывод списка инструментов по id категории

Route::get('/equipment', [EquipmentController::class, 'index'])->middleware('auth'); //Список инструментов
Route::get('/equipment/create', [EquipmentController::class, 'create'])->middleware('auth');// создание инструмента класса
Route::post('/equipment', [EquipmentController::class, 'store'])->middleware('auth');
Route::get('/equipment/edit/{id}', [EquipmentController::class, 'edit'])->middleware('auth'); //редактирование
Route::put('/equipment/update/{id}', [EquipmentController::class, 'update'])->middleware('auth'); //обновление редактирования инструмента
Route::get('/equipment/destroy/{id}', [EquipmentController::class, 'destroy'])->middleware('auth'); //удаление интсрумента
Route::get('/equipment/{id}', [EquipmentController::class, 'show'])->middleware('auth')->name('equipment.show');//Вывод списка аренд с этим инструментом


Route::get('/user', [UserController::class, 'index'])->middleware('auth'); //Список пользователей
Route::get('/user/{id}', [UserController::class, 'show'])->middleware('auth')->name('user.show'); //Заказ пользователя

Route::get('/rental', [RentalController::class, 'index'])->middleware('auth'); //Список всех инструментов в аренде


//аунтификация
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout']);
Route::post('/auth', [LoginController::class, 'authenticate']);

//уведомление об ошибке
Route::get('error', function (){
    return view('error', ['message' => session('message')]);
});
