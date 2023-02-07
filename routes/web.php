<?php


use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Admin\TranslationManager;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PageController::class, 'home'])->name('frontend.home');
Route::get('/contact', [PageController::class, 'Contact'])->name('frontend.contact');
Route::post('save-contact', [PageController::class, 'saveContact'])->name('contact.save');
Route::get('/about', [PageController::class, 'About'])->name('frontend.about');
Route::get('/brands', [PageController::class, 'Brands'])->name('frontend.brands');
Route::get('/stories', [PageController::class, 'Stories'])->name('frontend.stories');
Route::get('/partners', [PageController::class, 'Partners'])->name('frontend.partners');
Route::get('/facts', [PageController::class, 'Facts'])->name('frontend.facts');

Route::get('translation-manager', [TranslationManager::class, 'index'])->name('translationmanager');

Route::get('local/{locale}', [LanguageController::class, 'changeLanguage']);
Route::get('language/{country_name}', [LanguageController::class, 'getLanguage']);
Route::get('change-language/{id}/{country_name}', [LanguageController::class, 'getOnChangeLanguage']);
Route::get('get_language_by_id/{id}', [LanguageController::class, 'getLanguageById']);

Route::post('/block/delete/{record}', [\App\Filament\Resources\PageResource::class, 'deleteBlock'])
    ->name('page.block.delete');
