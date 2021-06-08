<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PlayerController;
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

Route::get('/', function ()
{
    return view('welcome');
});

Route::get('players', PlayerController::class);

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::get('/', [AdminController::class, 'show'])->name('home');
    Route::post('add-player', [AdminController::class, 'addPlayer'])->name('addPlayer');

    Route::group(['prefix' => 'player/{player}'], function() {
        Route::get('/', [AdminController::class, 'playerInfo'])->name('playerInfo');
        Route::get('add-beverage', [AdminController::class, 'addBeverage'])->name('addBeverage');
        Route::get('complete-beverage', [AdminController::class, 'completeBeverage'])->name('completeBeverage');
        Route::get('undo-beverage', [AdminController::class, 'undoBeverage'])->name('undoBeverage');
    });

    Route::get('login', [AdminController::class, 'login'])->name('login');
    Route::post('login', [AdminController::class, 'doLogin'])->name('doLogin');
});





