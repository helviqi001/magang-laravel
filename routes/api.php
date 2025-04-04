<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Middleware\CheckAuthFrontend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function (Request $request) {
    return 'Laravel ' . app()->version();
});

Route::get('/health-check', function (Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'OK',
    ], 200);
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'doLogin');
});

// start checking auth
Route::middleware([CheckAuthFrontend::class])->group(function () {

    // Profile
    Route::controller(AuthController::class)->group(function () {
        Route::get('profile', 'profile');
        Route::post('profile', 'profileUpdate');
        Route::post('profile/change-password', 'changePassword');
    });
});
// end checking auth