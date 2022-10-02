<?php

use App\Http\Resources\IngredientsFridge;
use App\Models\Fridge;
use App\Models\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FridgeRepository {

    public function getFridgeById(){

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

        $resourceIngredientsFrigde = new IngredientsFridge();
        $results =[];
        if (count($userFridge) > 0) {

            $results = ["id" => $userFridge[0]->fridge_id, "ingredients" => $resourceIngredientsFrigde->payload($userFridge)];
        }
        return response(["total_results" => count($userFridge), "results" => $results], 200);

    }
 }