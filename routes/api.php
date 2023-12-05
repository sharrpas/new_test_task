<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\UserController;
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

Route::post('send-code', [UserController::class, 'requestCode']);

Route::post('login', [UserController::class, 'login']);
Route::post('signup', [UserController::class, 'sighup']);

Route::get('products',[\App\Http\Controllers\User\ProductController::class,'index']);
Route::get('product/{product}',[\App\Http\Controllers\User\ProductController::class,'show']);


                                                           //تا فقط یوزر ها بتوانند ثبت سفارش کنند
                                            //و کاربرانی که لاگین نیستند این قابلیت را نداشته باشند
Route::post('order/product/{product}',[OrderController::class,'store'])->middleware(['auth:sanctum', 'role:user']);


Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    //products
    Route::get('products',[ProductController::class,'index']);
    Route::get('product/{product}',[ProductController::class,'show']);
    Route::post('product',[ProductController::class,'store']);

    Route::get('orders',[\App\Http\Controllers\Admin\OrderController::class,'index']);

});
