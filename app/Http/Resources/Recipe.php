<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipeRessources
{
 
    
    public function payload($data) 
    {


        $response = [];
        $arrayInfos = [];
        $arrayIngredients = [];
        $arrayRecipeSteps = [];

            $recipeInfo = $data['recipe']["infos"];
            $recipeIngredients = $data['recipe']["ingredients"];
            $recipeSteps = $data['recipe']["steps"];

            
            foreach($recipeIngredients as $ingredient){

                array_push($arrayIngredients, [
                    "id" => $ingredient->ingredient_id,
                    "name" => $ingredient->integration_name,
                    "image"=> $ingredient->image === null ? '' : $ingredient->image,
                    "category_id"=> $ingredient->ingredient_category_id,
                    "quantity"=> $ingredient->quantity === null ? 0 : $ingredient->quantity,
                    "unit_name"=> $ingredient->unit === "" ? null : $ingredient->unit
                ]);
            }

            foreach($recipeSteps as $steps){

                array_push($arrayRecipeSteps, [
                    "step_number" => intVal($steps->step_number),
                    "step" => $steps->step,
                ]);
            }

            array_push($response, [
                'id' => $recipeInfo->id,
                'title' => $recipeInfo->title ,
                'summary' => $recipeInfo->summary ,
                'image' => $recipeInfo->image ,
                'ready_in_minutes' => $recipeInfo->ready_in_minutes,
                'serving' => $recipeInfo->servings,
                'preparation_minutes' => $recipeInfo->preparation_minutes,
                'cooking_minutes' => $recipeInfo->cooking_minutes,
                'vegetarian' => boolval($recipeInfo->vegetarian),
                'vegan' => boolval($recipeInfo->vegan),
                'gluten_free' => boolval($recipeInfo->gluten_free),
                'dairy_free' => boolval($recipeInfo->dairy_free),
                "ingredients_list" => $arrayIngredients,
                "recipe_steps" => $arrayRecipeSteps,
                'created_at' => $recipeInfo->created_at == null ? 0 : $recipeInfo->created_at,
                'updated_at' => $recipeInfo->updated_at == null ? 0 : $recipeInfo->updated_at,
            ]);

        return $response;
    }
}
