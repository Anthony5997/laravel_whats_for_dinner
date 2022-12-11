<?php

namespace App\Http\Repositories;

use App\Models\Fridge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FridgeRepository{

    protected $fridge;

    public function __construct(Fridge $fridge)
    {
        $this->fridge = $fridge;
    }

    public function getUserFridge(){

        $userFridge = DB::select("SELECT ingredient_categories.*, ingredients.*, 
        ingredients_fridge.id as ingredient_fridge_id,
        ingredients_fridge.quantity,
        ingredients_fridge.unit_id,
        units.unit_name,
        fridges.id as fridge_id
        FROM fridges
        INNER JOIN ingredients_fridge ON ingredients_fridge.fridge_id = fridges.id
        INNER JOIN ingredients ON ingredients.id = ingredients_fridge.ingredient_id
        INNER JOIN ingredient_categories ON ingredient_categories.id = ingredients.ingredient_category_id
        INNER JOIN units ON units.id = ingredients_fridge.unit_id
        WHERE fridges.user_id = :id", ['id' => Auth::id()] );

        return $userFridge;
    }

    public function getOneIngredientFridge($fridgeId, $ingredientId){

        $ingredientFound = DB::table('ingredients_fridge')
        ->where('ingredients_fridge.fridge_id', $fridgeId)
        ->where('ingredients_fridge.ingredient_id' , $ingredientId)
        ->first();

        return $ingredientFound;
    }

    public function insertIngredientFridge($fridgeId, $ingredientId, $quantity, $unit){

        DB::table('ingredients_fridge')->insert(
            ['fridge_id' => $fridgeId, 'ingredient_id' => $ingredientId, "quantity" => $quantity, "unit_id" => $unit]);
        $response = "Ajout réussis";

        return $response;
    }

    public function insertNewQuantityIngredientFridge($fridgeId, $ingredientId,$ingredientFound, $quantity){

        DB::table('ingredients_fridge')
                    ->where('ingredients_fridge.fridge_id', $fridgeId)
                    ->where('ingredients_fridge.ingredient_id' , $ingredientId)
                    ->update(['quantity' => $ingredientFound->quantity += $quantity]);
        $response = "Nouvelle quantitée ajouter";

        return $response;
    }

    public function updateQuantityIngredientFridge($fridgeId, $ingredientId,$ingredientFound, $quantity){

        DB::table('ingredients_fridge')
                ->where('ingredients_fridge.fridge_id', $fridgeId)
                ->where('ingredients_fridge.ingredient_id' , $ingredientId)
                ->update(['quantity' => $ingredientFound->quantity = $quantity]);
        $response = "Quantitée modifié";

        return $response;
    }

    public function updateQuantityAndUnitIngredientFridge($fridgeId, $ingredientId,$ingredientFound, $quantity, $unit){

        DB::table('ingredients_fridge')
                ->where('ingredients_fridge.fridge_id', $fridgeId)
                ->where('ingredients_fridge.ingredient_id' , $ingredientId)
                ->update(['quantity' => $ingredientFound->quantity = $quantity, "unit_id" => $ingredientFound->unit_id = $unit == null ? $ingredientFound->unit_id : $unit]);
        $response = "Quantitée et unitée modifié";

        return $response;
    }

    public function deleteIngredientFridge($fridgeId, $ingredientId){

        DB::table('ingredients_fridge')
              ->where('ingredients_fridge.fridge_id', $fridgeId)
              ->where('ingredients_fridge.ingredient_id' , $ingredientId)
              ->delete();
        $response = "Suppression réussis";

        return $response;
    }


    public function deleteAllIngredientFridge($fridgeId){

        DB::table('ingredients_fridge')
              ->where('ingredients_fridge.fridge_id', $fridgeId)
              ->truncate();
        $response = "Suppression des ingrédients réussis";
        return $response;
    }
 }