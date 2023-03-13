<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Verification\Http\Controllers\VerificationController;

Route::prefix('verifications')->middleware('api')->group(function () {
       Route::post('/', [VerificationController::class, 'store']);
       Route::post('{verification}/confirm', [VerificationController::class, 'confirm']);
});
