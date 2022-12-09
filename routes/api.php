<?php

use App\Http\Controllers\UserController;
use App\Http\Requests\EmailVerificationRequest as RequestsEmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('users/add', [UserController::class,'add']);
Route::get('users/verfiy/{id}/{hash}',[UserController::class,'verfiyEmail'])->name("verfiy.user");
Route::get('users/login', [UserController::class,'login']);
Route::get('users/forgot', [UserController::class,'forgotUser'])->name('forgot');
Route::get('/reset-password/{token}', function ($token) {
    return "change passwor now with this toke :".$token;
})->middleware('guest')->name('password.reset');
Route::post('/reset-password', [UserController::class,'restPasswordUser'])
->middleware('guest')->name('password.update');





















// Route::post('users/add', [UserController::class,'addUser']);
// Route::get('/email/verify', function () {
//     return "mail send";
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
//     return "home";
// })->name('verification.verify');
// Route::get('users/login', [UserController::class,'loginUser'])->name('login');
// Route::get('users/forgot', [UserController::class,'forgotUser'])->name('forgot');
// Route::get('/reset-password/{token}', function ($token) {
//     return "change passwor now with this toke :".$token;
// })->middleware('guest')->name('password.reset');

// Route::post('/reset-password', [UserController::class,'restPasswordUser'])
// ->middleware('guest')->name('password.update');