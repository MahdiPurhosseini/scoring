<?php

    use App\Http\Controllers\Api\Auth\AuthController;
    use App\Http\Controllers\Api\RoleController;
    use App\Http\Controllers\Api\UserController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\UserDeviceAPIController;

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

    Route::group( [ 'as' => 'api.' ] , function () {

        Route::post( '/register' , [ AuthController::class , 'register' ] )->name( 'register' )->middleware("throttle:60,1");
        Route::post( '/login' , [ AuthController::class , 'login' ] )->name( 'login' )->middleware("throttle:60,1");
        Route::post( '/check/code' , [ AuthController::class , 'checkCode' ] )->name( 'check.code' )->middleware("throttle:60,1");

        Route::group( [ 'prefix' => 'user' ] , function () {
            Route::get( '/' , [ UserController::class , 'index' ] )->name( 'user' );
            Route::get( '/show/{id}' , [ UserController::class , 'show' ] )->name( 'user.show' );
            Route::post( '/score' , [ UserController::class , 'score' ] )->name( 'user.score' );
            Route::get( '/delete/{id}' , [ UserController::class , 'delete' ] )->name( 'user.delete' );
        } );

        Route::group( [ 'prefix' => 'role' ] , function () {
            Route::get( '/' , [ RoleController::class , 'index' ] )->name( 'role' );
            Route::get( '/show/{id}' , [ RoleController::class , 'show' ] )->name( 'role.show' );
            Route::post( '/store' , [ RoleController::class , 'store' ] )->name( 'role.store' );
            Route::get( '/delete/{id}' , [ RoleController::class , 'delete' ] )->name( 'role.delete' );
        } );

    } );

    Route::post('user-device/register', [UserDeviceAPIController::class, 'registerDevice'])->name('registerDevice');
    Route::get('user-device/{playerId}/update-status', [UserDeviceAPIController::class, 'updateNotificationStatus']);
