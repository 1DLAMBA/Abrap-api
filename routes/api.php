<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\fileUploadController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/register', [AdminController::class, 'register']);
Route::get('/user/get/unapproved', [UserController::class, 'show']);
Route::get('/user/get/unapproved/{id}', [UserController::class, 'showunapproved']);
Route::get('/user/get/{id}', [UserController::class, 'showuser']);
Route::post('/user/approve/{id}', [UserController::class, 'approve']);
Route::get('/user/reject/{id}', [UserController::class, 'reject']);
Route::post('/user/extra/{id}', [UserController::class, 'register2']);
Route::post('/user/account/{id}', [UserController::class, 'account']);
Route::post('/user/activate/{id}', [UserController::class, 'activate']);
Route::get('/user/update/{id}', [LoanController::class, 'update']);
Route::post('/upload', [FileUploadController::class, 'upload'])->name('file.upload');
Route::post('/multi-upload', [FileUploadController::class, 'multiUpload']);

Route::get('/file/get/{filename}/{visibility?}', [FileUploadController::class, 'getFile'])->name('file.get');


Route::post('/user/loan', [LoanController::class, 'create']);
Route::get('/user/loan/update/{id}', [LoanController::class, 'upload']);
