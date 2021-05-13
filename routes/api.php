<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RunController;
use App\Http\Controllers\RunnerController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ResultController;

Route::post('/run', [RunController::class, 'store'])->name('run.store');
Route::post('/runner', [RunnerController::class, 'store'])->name('runner.store');
Route::post('/subscription', [SubscriptionController::class, 'store'])->name('subscription.store');
Route::post('/result', [ResultController::class, 'store'])->name('result.store');
Route::get('/generalresult/{run}', [ResultController::class, 'generalResult'])->where('run', '[0-9]+')->name('result.generalResult');
Route::get('/perageresult/{run}', [ResultController::class, 'perAgeResult'])->where('run', '[0-9]+')->name('result.perAgeResult');
