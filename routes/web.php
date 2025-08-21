<?php

use App\Http\Controllers\AccidentController;
use App\Http\Controllers\AgcController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PicaController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::get('captcha', [CaptchaController::class, 'captcha'])->name('captcha');
Route::get('otp', [OtpController::class, 'otpVerif'])->name('otp-verif');

Route::post('verify-otp', [OtpController::class, 'verify'])->name('verify-otp');
Route::post('resend-otp', [OtpController::class, 'resendOtp'])->name('resend-otp');

//MAIN FEATURES
Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('accident', [MainController::class, 'accident'])->name('accident');
Route::get('monitoring', [MainController::class, 'monitoring'])->name('monitoring');
Route::get('agc', [MainController::class, 'agc'])->name('agc');
Route::get('pica-admin', [MainController::class, 'picaAdmin'])->name('pica-admin');
Route::get('issue-admin', [MainController::class, 'issueAdmin'])->name('issue-admin');

//ACCIDENT FEATURES
Route::post('accident-post', [AccidentController::class, 'accidentPost'])->name('accident-post');
Route::post('accident-update', [AccidentController::class, 'accidentUpdate'])->name('accident-update');
Route::post('accident-delete', [AccidentController::class, 'accidentDelete'])->name('accident-delete');

//ACCIDENT FEATURES
Route::post('agc-post', [AgcController::class, 'agcPost'])->name('agc-post');
Route::post('agc-update', [AgcController::class, 'agcUpdate'])->name('agc-update');
Route::post('agc-delete', [AgcController::class, 'agcDelete'])->name('agc-delete');

//PICA FEATURES
Route::get('pica/{day}', [PicaController::class, 'pica'])->name('pica');
Route::post('pica-post', [PicaController::class, 'picaPost'])->name('pica-post');
Route::post('pica-image-post', [PicaController::class, 'picaImagePost'])->name('pica-image-post');
Route::post('pica-update', [PicaController::class, 'picaUpdate'])->name('pica-update');
Route::post('pica-delete', [PicaController::class, 'picaDelete'])->name('pica-delete');

//PICA FEATURES
Route::get('issue', [IssueController::class, 'issue'])->name('issue');
Route::post('issue-post', [IssueController::class, 'issuePost'])->name('issue-post');
Route::post('issue-image-post', [IssueController::class, 'issueImagePost'])->name('issue-image-post');
Route::post('issue-update', [IssueController::class, 'issueUpdate'])->name('issue-update');
Route::post('issue-delete', [IssueController::class, 'issueDelete'])->name('issue-delete');




require __DIR__ . '/auth.php';
