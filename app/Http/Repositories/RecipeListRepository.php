<?php

namespace App\Http\Repositories;

use App\Models\Recipe;
use Illuminate\Support\Facades\DB;

class RecipeListRepository{

    protected $recipe;

    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }


    public function getAllIngredientsRecipe($recipe){

        $ingredientsRecipe = DB::select(
            "SELECT 
            ingredient_id,
            integration_name, 
            quantity,
            unit, 
            ingredients.image,
            ingredients.ingredient_category_id
            FROM ingredient_recipes
            INNER JOIN ingredients ON ingredients.id = ingredient_recipes.ingredient_id
            WHERE recipe_id = :id", ["id" =>  $recipe->id]);

        return $ingredientsRecipe;
    }

    public function getAllRecipeSteps($recipe){

        $allRecipeSteps = DB::select("SELECT `step_number`, `step` FROM `recipe_steps` WHERE `recipe_id` = :id ORDER BY `step_number` ASC", ["id" => $recipe->id]);

        return $allRecipeSteps;
    }
 }