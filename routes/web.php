<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\PlayController;
use App\Http\Livewire\SeriesIndex;
use App\Http\Livewire\SeasonIndex;
use App\Http\Livewire\EpisodeIndex;
use App\Http\Controllers\InstagramController;
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

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/series', [SeriesController::class, 'index'])->name('series.index');
Route::get('/series/{series}', [SeriesController::class, 'show'])->name('series.show');
Route::get('/series/{series}/seasons/{season}', [SeriesController::class, 'seasonShow'])->name('season.show');
Route::get('/play/{episode}', [SeriesController::class, 'showEpisode'])->name('episode.player');

Route::middleware(['auth:sanctum', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('series', SeriesIndex::class)->name('series.index');
    Route::get('series/{series}/seasons', SeasonIndex::class)->name('seasons.index');
    Route::get('series/{series}/seasons/{season}/episodes', EpisodeIndex::class)->name('episodes.index');
});

Route::get('instagram', [InstagramController::class, 'index'])->name('instagram');
Route::post('instagram', [InstagramController::class, 'store'])->name('instagram.store');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');