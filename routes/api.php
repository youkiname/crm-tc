<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RegistrationController;

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

Route::get('customer/auth', [AuthController::class, 'authCustomer']);
Route::get('seller/auth', [AuthController::class, 'authSeller']);
Route::get('renter/auth', [AuthController::class, 'authRenter']);
Route::get('admin/auth', [AuthController::class, 'authAdmin']);

Route::get('auth', [AuthController::class, 'authCustomer']);
Route::get('auth/verify', [AuthController::class, 'verifyAuth']);

Route::post('register', [RegistrationController::class, 'registerCustomer']);

Route::post('users/reset_password', [ResetPasswordController::class, 'resetPassword']);
Route::get('users/verify_password_reset', [ResetPasswordController::class, 'verifyPasswordReset']);
Route::post('users/update_password', [ResetPasswordController::class, 'updatePassword']);

Route::middleware('auth:api')->group(function () {
    Route::get('auth/refresh', [AuthController::class, 'refresh']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('get_me', [AuthController::class, 'getMe']);
    Route::post('users/verify_email', [VerificationController::class, 'verify']);
    Route::get('shops/categories', [App\Http\Controllers\Abstract\ShopController::class, 'getCategories']);

    Route::middleware('role:customer')->prefix('customer')->group(function () {
        Route::get('polls', [App\Http\Controllers\Customer\CustomerPollController::class, 'index']);
        Route::get('polls/shopping_centers', [App\Http\Controllers\Customer\CustomerPollController::class, 'getCenters']);
        Route::get('polls/{id}', [App\Http\Controllers\Customer\CustomerPollController::class, 'show']);
        Route::post('polls/make_choice', [App\Http\Controllers\Customer\CustomerPollController::class, 'makeChoice']);
        Route::get('shopping_centers', [App\Http\Controllers\Customer\CustomerShoppingCenterController::class, 'index']);
        Route::put('update_profile', [App\Http\Controllers\Customer\CustomerProfileController::class, 'update']);
        Route::post('statistic/visitors', [App\Http\Controllers\Abstract\StatisticController::class, 'storeVisitor']);
        Route::get('users/by_card_number', [App\Http\Controllers\Customer\CustomerUserController::class, 'showUserByCardNumber']);
        Route::get('banners', [App\Http\Controllers\Customer\CustomerBannerController::class, 'index']);
    });

    Route::middleware('role:seller')->prefix('seller')->group(function () {
        Route::post('cards/update_bonuses', [App\Http\Controllers\Abstract\CardController::class, 'updateBonuses']);
        Route::post('customers/by_card', [App\Http\Controllers\Seller\SellerCustomerController::class, 'showByCardNumber']);
    });

    Route::middleware('role:renter')->prefix('renter')->group(function () {
        Route::get('transactions', [App\Http\Controllers\Renter\RenterTransactionController::class, 'index']);
        Route::resource('sellers', App\Http\Controllers\Renter\RenterSellerController::class);
        Route::get('statistic/customers', [App\Http\Controllers\Renter\RenterStatisticController::class, 'getCustomerStatistics']);
        Route::get('statistic/sellers', [App\Http\Controllers\Renter\RenterStatisticController::class, 'getSellerStatistics']);
        Route::get('statistic/transactions/sum', [App\Http\Controllers\Renter\RenterTransactionController::class, 'getAmountSum']);
        Route::get('statistic/transactions/sum/today', [App\Http\Controllers\Renter\RenterTransactionController::class, 'getAmountSumToday']);
        Route::get('statistic/transactions/sum/month', [App\Http\Controllers\Renter\RenterTransactionController::class, 'getAmountSumMonth']);
        Route::get('statistic/transactions/average_sum/today', [App\Http\Controllers\Renter\RenterTransactionController::class, 'getAverageSumToday']);
        Route::get('statistic/transactions/average_sum/month', [App\Http\Controllers\Renter\RenterTransactionController::class, 'getAverageSumMonth']);
        Route::get('statistic/transactions/average_sum/graph', [App\Http\Controllers\Renter\RenterTransactionController::class, 'getAverageSumGraph']);
        Route::get('statistic/transactions/sales_rate', [App\Http\Controllers\Renter\RenterTransactionController::class, 'getSalesRate']);
        Route::get('statistic/visitors/today', [App\Http\Controllers\Renter\RenterStatisticController::class, 'getVisitorsAmountToday']);
        Route::get('statistic/visitors/month', [App\Http\Controllers\Renter\RenterStatisticController::class, 'getVisitorsAmountMonth']);
        Route::get('statistic/visitors_graph', [App\Http\Controllers\Renter\RenterStatisticController::class, 'getVisitorsGraph']);
        Route::get('statistic/visitors_graph/month', [App\Http\Controllers\Renter\RenterStatisticController::class, 'getVisitorsGraphMonth']);
        Route::get('statistic/visitors/age_plot', [App\Http\Controllers\Renter\RenterStatisticController::class, 'getVisitorsAgePlot']);
        Route::get('statistic/visitors/age_plot/week', [App\Http\Controllers\Renter\RenterStatisticController::class, 'getVisitorsAgePlotWeek']);
        Route::get('statistic/visitors/age_plot/month', [App\Http\Controllers\Renter\RenterStatisticController::class, 'getVisitorsAgePlotMonth']);
        Route::get('statistic/visitors/age_plot/year', [App\Http\Controllers\Renter\RenterStatisticController::class, 'getVisitorsAgePlotYear']);
        Route::post('register_seller', [RegistrationController::class, 'registerSeller']);
        Route::put('update_profile', [App\Http\Controllers\Renter\RenterProfileController::class, 'update']);
    });

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::put('update_profile', [App\Http\Controllers\Admin\AdminProfileController::class, 'update']);
        Route::resource('cities', App\Http\Controllers\Abstract\CityController::class);
        Route::resource('card_statuses', App\Http\Controllers\Abstract\CardStatusController::class);
        Route::resource('shops', App\Http\Controllers\Admin\AdminShopController::class);
        Route::resource('sellers', App\Http\Controllers\Admin\AdminSellerController::class);
        Route::resource('renters', App\Http\Controllers\Admin\AdminRenterController::class);
        Route::resource('transactions', App\Http\Controllers\Admin\AdminTransactionController::class);
        Route::put('banners/activate/{id}', [App\Http\Controllers\Admin\AdminBannerController::class, 'activateBanner']);
        Route::put('banners/deactivate/{id}', [App\Http\Controllers\Admin\AdminBannerController::class, 'deactivateBanner']);
        Route::resource('banners', App\Http\Controllers\Admin\AdminBannerController::class);
        Route::put('polls/activate/{id}', [App\Http\Controllers\Admin\AdminPollController::class, 'activatePoll']);
        Route::put('polls/deactivate/{id}', [App\Http\Controllers\Admin\AdminPollController::class, 'deactivatePoll']);
        Route::resource('polls', App\Http\Controllers\Admin\AdminPollController::class);
        Route::get('statistic/shops', [App\Http\Controllers\Admin\AdminStatisticController::class, 'getShopStatistics']);
        Route::get('statistic/customers', [App\Http\Controllers\Admin\AdminStatisticController::class, 'getCustomerStatistics']);
        Route::get('statistic/sellers', [App\Http\Controllers\Admin\AdminStatisticController::class, 'getSellerStatistics']);
        Route::get('statistic/transactions/sum', [App\Http\Controllers\Admin\AdminTransactionController::class, 'getAmountSum']);
        Route::get('statistic/transactions/sum/today', [App\Http\Controllers\Admin\AdminTransactionController::class, 'getAmountSumToday']);
        Route::get('statistic/transactions/sum/month', [App\Http\Controllers\Admin\AdminTransactionController::class, 'getAmountSumMonth']);
        Route::get('statistic/transactions/average_sum/today', [App\Http\Controllers\Admin\AdminTransactionController::class, 'getAverageSumToday']);
        Route::get('statistic/transactions/average_sum/month', [App\Http\Controllers\Admin\AdminTransactionController::class, 'getAverageSumMonth']);
        Route::get('statistic/transactions/average_sum/graph', [App\Http\Controllers\Admin\AdminTransactionController::class, 'getAverageSumGraph']);
        Route::get('statistic/transactions/sales_rate', [App\Http\Controllers\Admin\AdminTransactionController::class, 'getSalesRate']);
        Route::get('statistic/visitors/today', [App\Http\Controllers\Admin\AdminStatisticController::class, 'getVisitorsAmountToday']);
        Route::get('statistic/visitors/month', [App\Http\Controllers\Admin\AdminStatisticController::class, 'getVisitorsAmountMonth']);
        Route::get('statistic/visitors_graph', [App\Http\Controllers\Admin\AdminStatisticController::class, 'getVisitorsGraph']);
        Route::get('statistic/visitors_graph/month', [App\Http\Controllers\Admin\AdminStatisticController::class, 'getVisitorsGraphMonth']);
        Route::get('statistic/visitors/age_plot', [App\Http\Controllers\Admin\AdminStatisticController::class, 'getVisitorsAgePlot']);
        Route::get('statistic/visitors/age_plot/week', [App\Http\Controllers\Admin\AdminStatisticController::class, 'getVisitorsAgePlotWeek']);
        Route::get('statistic/visitors/age_plot/month', [App\Http\Controllers\Admin\AdminStatisticController::class, 'getVisitorsAgePlotMonth']);
        Route::get('statistic/visitors/age_plot/year', [App\Http\Controllers\Admin\AdminStatisticController::class, 'getVisitorsAgePlotYear']);
        Route::post('register_renter', [RegistrationController::class, 'registerRenter']);
        Route::get('shopping_centers', [App\Http\Controllers\Abstract\ShoppingCenterController::class, 'index']);
    });
    
    Route::middleware('role:superadmin')->prefix('superadmin')->group(function () {
        Route::resource('shopping_centers', App\Http\Controllers\Abstract\ShoppingCenterController::class);
        Route::resource('users', App\Http\Controllers\Abstract\UserController::class);
        Route::post('register_admin', [RegistrationController::class, 'registerAdmin']);
    });
});
