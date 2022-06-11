<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return Route::get('/ingredients', [RecipeController::class, 'getAllIngredients']);
// });


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/auth/login', [AuthController::class, 'loginUser']);
    Route::get('/ingredients', [RecipeController::class, 'getAllIngredients']);
});



// Route::get('/record', [RecipeController::class, 'getApiInfos']);
// // Route::get('/ingredients', [RecipeController::class, 'getAllIngredients']);

// Route::post('/auth/register', [AuthController::class, 'createUser']);
// Route::post('/auth/login', [AuthController::class, 'loginUser']);