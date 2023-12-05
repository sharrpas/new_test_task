<?php

use App\Http\Controllers\Admin\ProductController;
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


Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    //products
    Route::post('product',[ProductController::class,'store']);


});
