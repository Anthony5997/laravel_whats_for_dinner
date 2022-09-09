<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FridgeController;
use App\Http\Controllers\IngredientCategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UnitsController;
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
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/ingredients', [IngredientController::class, 'getAllIngredients'])->name('getAllIngredients');
    Route::get('/ingredients/category', [IngredientCategoryController::class, 'getAllIngredientCategories'])->name('getAllIngredientCategories');
    Route::get('/ingredients/category/{id}', [IngredientController::class, 'getIngredientsByCategory']);
    Route::get('/fridge', [FridgeController::class, 'getFridgeIngredientsByUser']);
    Route::post('/fridge/addIngredient', [FridgeController::class, 'addIngredientIntoFridge']);
    Route::post('/fridge/deleteIngredient', [FridgeController::class, 'deleteIngredientFromFridge']);
});


Route::get('/record', [RecipeController::class, 'getApiInfos']);
Route::get('/units', [UnitsController::class, 'getAllUnits']);


Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/auth/register', [AuthController::class, 'createUser']);