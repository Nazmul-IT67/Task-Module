<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\FileUploadController;

Route::get('/', function () {
    return view('welcome');
});

// LoginController
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('auth.login');})->name('login');
    Route::get('/register', function () { return view('auth.register'); })->name('register');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// FileUploadController
// WLL Uploader
Route::controller(FileUploadController::class)->prefix('wll-uploader')->group(function () {
    Route::post('/', 'show_uploader');
    Route::post('/upload', 'upload');  
    Route::get('/get-uploaded-files', 'get_uploaded_files');
    Route::post('/get_file_by_ids', 'get_preview_files');
    Route::get('/download/{id}', 'attachment_download')->name('download_attachment');
});
// file uploads
Route::controller(FileUploadController::class)->prefix('uploaded-files')->group(function () {
    Route::get('/', 'index')->name('uploaded-files.index');
    Route::get('create', 'create')->name('uploaded-files.create');
    Route::delete('{id}/destroy', 'destroy')->name('uploaded-files.destroy');
    Route::post('upload', 'upload'); 
    Route::get('get-uploaded-files', 'get_uploaded_files')->name('get_uploaded_files');
    Route::post('get_file_by_ids', 'get_preview_files');
    Route::post('show-uploader', 'show_uploader');
    Route::any('info', 'uploaded_files_info')->name('uploaded_files_info');
    Route::post('bulk-delete', 'uploaded_files_bulk_delete')->name('uploaded_files_bulk_delete');
});

Route::get('/refresh-csrf', function () {
    return csrf_token();
});
