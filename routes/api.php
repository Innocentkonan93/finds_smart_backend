<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\PackBenefitController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\WalletTransactionController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\UnlockedProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/verify-email', [AuthController::class, 'verifyEmail']);;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('documents', DocumentController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('job-categories', JobCategoryController::class);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('subscriptions', SubscriptionController::class);
    Route::apiResource('packs', PackController::class);
    Route::apiResource('pack-benefits', PackBenefitController::class);
    Route::apiResource('notifications', NotificationController::class);
    Route::apiResource('ads', AdController::class);
    Route::apiResource('wallets', WalletController::class);
    Route::apiResource('wallet-transactions', WalletTransactionController::class);
    Route::apiResource('unlocked-profiles', UnlockedProfileController::class);
    Route::apiResource('transactions', TransactionController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/upload-documents', [DocumentController::class, 'upload']);
    Route::post('/users/set-availability', [UserController::class, 'setAvailability']);
    Route::post('/users/delete', [UserController::class, 'deleteUser']);
    Route::get('/professionals', [UserController::class, 'getProfessionals']);
    Route::get('/professionals/job/{jobCategory}', [UserController::class, 'getProfessionalsByJobCategory']);
    Route::get('/services/user/{user_id}', [ServiceController::class, 'getServicesByUser']);
    Route::get('/services/user/{user_id}/category/{category}', [ServiceController::class, 'getUserServicesByCategory']);
    Route::get('/orders/client/{id}', [OrderController::class, 'getClientOrders']);
    Route::get('/orders/professional/{id}', [OrderController::class, 'getProfessionalOrders']);
    Route::get('/orders-accepted/{professional_id}', [OrderController::class, 'getAcceptedOrders']);
    Route::get('/orders-pending', [OrderController::class, 'pendingOrders']);
    Route::get('/orders-completed', [OrderController::class, 'completedOrders']);
    Route::post('/accept-order', [OrderController::class, 'acceptOrder']);
    Route::post('/complete-order', [OrderController::class, 'completeOrder']);
    Route::post('/upload-user-image', [UserController::class, 'uploadUserImage']);
    Route::post('/upload-service-image', [ServiceController::class, 'uploadServiceImage']);
    Route::get('/users/{user_id}/notifications', [UserController::class, 'getUserNotifications']);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);
    Route::post('/top-up-wallet', [WalletController::class, 'topUpWallet']);
    Route::post('/unlock-professional/{professional_id}', [UserController::class, 'unlockProfessional']);
    Route::post('/buy-pack', [WalletController::class, 'buyPack']);
    Route::get('/unlocked-profiles', [UnlockedProfileController::class, 'getUnlockedProfiles']);

    //
    Route::post('/paiementpro/init', [TransactionController::class, 'init']);
    Route::post('/paiementpro/notify', [TransactionController::class, 'notify']);
    Route::get('/paiementpro/retour', [TransactionController::class, 'retour']);
});
