<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\SubscriptionPlanController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\SubscriptionController;
use App\Http\Controllers\Api\V1\UserController;

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

Route::group(['prefix' => 'v1'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('profile', [UserController::class, 'getUserInfo']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::get('plans', [SubscriptionPlanController::class, 'getPlans']);
        Route::get('plan/{plan}', [SubscriptionPlanController::class, 'getPlan']);

        Route::get('braintree-token', [PaymentController::class, 'getToken']);
        Route::post('checkout', [PaymentController::class, 'checkout']);

        Route::get('user-subscription', [SubscriptionController::class, 'getCurrentUserSubscription']);
        Route::post('cancel-subscription', [SubscriptionController::class, 'cancelCurrentUserSubscription']);
    });
});
