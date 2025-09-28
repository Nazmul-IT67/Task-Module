<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\TaskController;


Route::post('tasks/bulk', [TaskController::class, 'storeMultiple']);
