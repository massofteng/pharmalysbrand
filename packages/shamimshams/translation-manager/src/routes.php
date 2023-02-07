<?php

use Illuminate\Support\Facades\Route;
use ShamimShams\TranslationManager\Controllers\TranslationController;


// Route::group(['namespace' => 'ShamimShams\TranslationManager\Controllers', 'middleware' => config('ltm.middleware', ['web'])], function() {
//     Route::get( 'translation-manager/download', [TranslationController::class, 'download'] )
//     ->name( 'ltm.download' );
// });

Route::get( 'translation-manager/download', [TranslationController::class, 'download'] )
    ->name( 'ltm.download' )
    ->middleware(config('ltm.middleware', ['web']));
