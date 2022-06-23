<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CardStatusController;
use App\Http\Controllers\ShoppingCenterController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdsBannerController;
use App\Http\Controllers\PollController;

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
Route::get('unauthorized', function () {
    return response()->json(['errors' => 'unauthorized'], 401);
})->name('api.unauthorized');

Route::get('auth', [AuthController::class, 'auth']);
Route::post('register', [RegistrationController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('users/verify_email', [VerificationController::class, 'verify']);
    Route::post('users/reset_password', [ResetPasswordController::class, 'resetPassword']);
    Route::get('users/verify_password_reset', [ResetPasswordController::class, 'verifyPasswordReset']);
    Route::post('users/update_password', [ResetPasswordController::class, 'updatePassword']);

    Route::post('users/update_profile', [UserController::class, 'updateProfile']);

    Route::post('users/update_bonuses', [CardController::class, 'updateBonuses']);
    Route::post('cards/update_bonuses', [CardController::class, 'updateBonuses']);

    Route::resource('users', UserController::class);
    Route::resource('card_statuses', CardStatusController::class);
    Route::resource('shopping_centers', ShoppingCenterController::class);
    Route::resource('shops', ShopController::class);
    Route::resource('messages', MessageController::class);
    Route::get('transactions/amount', [TransactionController::class, 'getAmount']);
    Route::resource('transactions', TransactionController::class);
    Route::resource('banners', AdsBannerController::class);

    Route::post('polls/make_choice', [PollController::class, 'makeChoice']);
    Route::get('polls/shopping_centers', [PollController::class, 'getCenters']);
    Route::resource('polls', PollController::class);
});

