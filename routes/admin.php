<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\LanguageController;


// LanguageController
Route::controller(LanguageController::class)->prefix('languages')->group(function () {
    Route::delete('trash/{id}', 'trash_confirm')->name('languages.trash.confirm');
    Route::post('restore/{id}', 'restore')->name('languages.restore');
    Route::get('trash', 'trash')->name('languages.trash');
    Route::post('status/{id}', 'status_change')->name('languages.status.change');
    Route::post('rtl/{id}', 'rtl_change')->name('languages.rtl.change');
    Route::post('default/{id}', 'default_change')->name('languages.default.change');
    Route::get('translation/{id}', 'translation')->name('languages.translation');
    Route::post('translation/{id}','translation_store')->name('languages.translation.store');
});
Route::resource('languages',languageController::class);