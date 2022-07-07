<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
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
use App\Http\Controllers\StatisticController;

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

Route::get('auth/customer', [AuthController::class, 'authCustomer']);
Route::get('auth/seller', [AuthController::class, 'authSeller']);
Route::get('auth/renter', [AuthController::class, 'authRenter']);
Route::get('auth/admin', [AuthController::class, 'authAdmin']);
Route::get('auth', [AuthController::class, 'authCustomer']);
Route::get('auth/verify', [AuthController::class, 'verifyAuth']);
Route::post('logout', [AuthController::class, 'logout']);


Route::post('register/customer', [RegistrationController::class, 'registerCustomer']);
Route::post('register/seller', [RegistrationController::class, 'registerSeller']);
Route::post('register/renter', [RegistrationController::class, 'registerRenter']);
Route::post('register/admin', [RegistrationController::class, 'registerAdmin']);
Route::post('register', [RegistrationController::class, 'registerCustomer']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me/admin', [AuthController::class, 'getMe']);

    Route::post('users/verify_email', [VerificationController::class, 'verify']);
    Route::post('users/reset_password', [ResetPasswordController::class, 'resetPassword']);
    Route::get('users/verify_password_reset', [ResetPasswordController::class, 'verifyPasswordReset']);
    Route::post('users/update_password', [ResetPasswordController::class, 'updatePassword']);

    Route::put('admins/update_profile', [AdminController::class, 'updateProfile']);
    Route::post('users/update_profile', [UserController::class, 'updateProfile']);

    Route::post('users/update_bonuses', [CardController::class, 'updateBonuses']);
    Route::post('cards/update_bonuses', [CardController::class, 'updateBonuses']);

    Route::resource('cities', CityController::class);
    Route::resource('users', UserController::class);
    Route::resource('card_statuses', CardStatusController::class);
    Route::resource('shopping_centers', ShoppingCenterController::class);
    Route::get('shops/categories', [ShopController::class, 'getCategories']);
    Route::resource('shops', ShopController::class);
    Route::resource('messages', MessageController::class);
    Route::resource('transactions', TransactionController::class);

    Route::put('banners/activate/{id}', [AdsBannerController::class, 'activateBanner']);
    Route::put('banners/deactivate/{id}', [AdsBannerController::class, 'deactivateBanner']);
    Route::resource('banners', AdsBannerController::class);

    Route::post('polls/make_choice', [PollController::class, 'makeChoice']);
    Route::get('polls/shopping_centers', [PollController::class, 'getCenters']);
    Route::put('polls/activate/{id}', [PollController::class, 'activatePoll']);
    Route::put('polls/deactivate/{id}', [PollController::class, 'deactivatePoll']);
    Route::resource('polls', PollController::class);

    Route::get('statistic/shops', [StatisticController::class, 'getShopStatistics']);
    Route::get('statistic/customers', [StatisticController::class, 'getCustomerStatistics']);

    Route::get('statistic/transactions/sum', [TransactionController::class, 'getAmountSum']);
    Route::get('statistic/transactions/sum/today', [TransactionController::class, 'getAmountSumToday']);
    Route::get('statistic/transactions/sum/month', [TransactionController::class, 'getAmountSumMonth']);
    Route::get('statistic/transactions/average_sum/today', [TransactionController::class, 'getAverageSumToday']);
    Route::get('statistic/transactions/average_sum/month', [TransactionController::class, 'getAverageSumMonth']);
    Route::get('statistic/transactions/average_sum/graph', [TransactionController::class, 'getAverageSumGraph']);
    Route::get('statistic/transactions/sales_rate', [TransactionController::class, 'getSalesRate']);

    Route::get('statistic/visitors/today', [StatisticController::class, 'getVisitorsAmountToday']);
    Route::get('statistic/visitors/month', [StatisticController::class, 'getVisitorsAmountMonth']);
    Route::post('statistic/visitors', [StatisticController::class, 'storeVisitor']);
    Route::get('statistic/visitors_graph', [StatisticController::class, 'getVisitorsGraph']);
    Route::get('statistic/visitors_graph/month', [StatisticController::class, 'getVisitorsGraphMonth']);
    Route::get('statistic/visitors/age_plot', [StatisticController::class, 'getVisitorsAgePlot']);
    Route::get('statistic/visitors/age_plot/week', [StatisticController::class, 'getVisitorsAgePlotWeek']);
    Route::get('statistic/visitors/age_plot/month', [StatisticController::class, 'getVisitorsAgePlotMonth']);
    Route::get('statistic/visitors/age_plot/year', [StatisticController::class, 'getVisitorsAgePlotYear']);
});
