<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ShoppingCenterController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('auth', [UserController::class, 'auth']);
Route::post('register', [UserController::class, 'register']);

Route::get('users/update_bonuses', [CardController::class, 'updateBonuses']);
Route::get('cards/update_bonuses', [CardController::class, 'updateBonuses']);

Route::resource('users', UserController::class);
Route::resource('shopping_centers', ShoppingCenterController::class);
Route::resource('shops', ShopController::class);
Route::resource('messages', MessageController::class);
Route::resource('transactions', TransactionController::class);
