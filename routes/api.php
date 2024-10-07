<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BioLinkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LinkProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StorePageController;
use App\Http\Controllers\ThemeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->group(function () {

    //> store activation
    Route::middleware(['checkStoreActivation'])->prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);

        //> product category
        Route::prefix('product/category')->group(function () {
            Route::get('/', [ProductCategoryController::class, 'index']);
            Route::post('create', [ProductCategoryController::class, 'create']);
            Route::post('update/{id}', [ProductCategoryController::class, 'update']);
            Route::delete('delete/{id}', [ProductCategoryController::class, 'delete']);
            Route::get('{id}', [ProductCategoryController::class, 'show']);
        });

        //> product
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::post('/create', [ProductController::class, 'create']);
            Route::post('/update/{id}', [ProductController::class, 'update']);
            Route::delete('/delete/{id}', [ProductController::class, 'delete']);
            Route::post('/update-status/{id}', [ProductController::class, 'updateStatus']);
            Route::get('/{id}', [ProductController::class, 'show']);
        });
        //> Product link
        Route::prefix('products')->group(function () {
            Route::post('/{id}/link/update/{link}', [LinkProductController::class, 'update']);
            Route::delete('/{id}/link/delete/{link}', [LinkProductController::class, 'delete']);
            Route::post('/{id}/link/create', [LinkProductController::class, 'create']);
        });
        //> Bio Link
        Route::prefix('bio-links')->group(function () {
            Route::get('/', [BioLinkController::class, 'index']);
            Route::post('/create', [BioLinkController::class, 'create']);
            Route::post('/update/{id}', [BioLinkController::class, 'update']);
            Route::post('/update-status/{id}', [BioLinkController::class, 'updateStatus']);
            Route::delete('/delete/{id}', [BioLinkController::class, 'delete']);
            Route::get('/{id}', [BioLinkController::class, 'show']);
        });

        Route::prefix('store')->group(function () {
            Route::post('/update', [StoreController::class, 'update']);
        });
    });

    //> profile
    Route::prefix('profile')->group(function () {
        Route::post('/store-activation', [ProfileController::class, 'storeProfileActivation']);
        Route::post('/check-username', [ProfileController::class, 'checkUsernameAvailability']);
        Route::get('/', [ProfileController::class, 'profile']);
        Route::post('/update-password', [ProfileController::class, 'updatePassword']);
    });
});

Route::prefix('auth')->group(function () {
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/otp-confirmation-forgot-password', [AuthController::class, 'otpCodeForgotPasswordConfirmation']);
    Route::post('/otp-confirmation-forgot-password-resend', [AuthController::class, 'resendOtpCodeForgotPassword']);
    Route::post('/new-password', [AuthController::class, 'newPassword']);

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/otp-confirmation', [AuthController::class, 'otpCodeConfirmation']);
    Route::post('/otp-confirmation-resend', [AuthController::class, 'resendOtpCode']);
    Route::post('/check-email-available', [AuthController::class, 'checkEmailAvailable']);

    //> auth google
    Route::get('google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::post('google', [AuthController::class, 'googleCallback']);

    Route::get('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum', 'ability:accessLoginMember']);
});

Route::prefix('store')->group(function () {
    Route::get('/{store}', [StorePageController::class, 'profile']);
    Route::get('/{store}/products', [StorePageController::class, 'products']);
    // TODO Detail product
    Route::get('/{store}/products/{id}', [StorePageController::class, 'show']);
});

Route::get('jilogs-4j@', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::get('/', static function () {
    return response()->json([
        'success' => true,
        'data' => [],
        'message' => 'Welcome Home'
    ]);
})->name('home');
