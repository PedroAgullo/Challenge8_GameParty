<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MessageController;



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


Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {

    //User routes
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('users/all', [UserController::class, 'all']);
    Route::resource('users', UserController::class);
    
    //Party routes
    Route::resource('parties', PartyController::class);
    Route::post('parties/findByName', [PartyController::class, 'findByName']);

    //Memberships routes
    Route::resource('memberships', MembershipController::class);
    Route::post('memberships/users', [MembershipController::class, 'countUserParty']);
    Route::post('memberships/userid', [MembershipController::class, 'userid']);
    
    //Games routes
    Route::post('games/id', [GameController::class, 'byId']);
    Route::post('games/findByName', [GameController::class, 'findByName']);
    Route::post('games/findByGenre', [GameController::class, 'findByGenre']);
    Route::resource('games', GameController::class);

    //Message routes
    Route::resource('messages', MessageController::class);

});