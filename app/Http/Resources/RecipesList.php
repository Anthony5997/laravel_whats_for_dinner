<?php

namespace App\Http\Resources;

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FridgeController;
use App\Http\Controllers\ReviewsController;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecipesList
{
 
    
    public function payload($data)
    {

        $favoriteController = new FavoriteController();
        $fridgeController = new FridgeController();
        $reviewController = new ReviewsController();
        $userFridge = $fridgeController->getFridgeIngredientsByUser();
        
        $dataDecode = json_decode($userFridge->content());
        $dataDecode = json_decode($userFridge->content());
        $fridgeIngredientsId = [];
        if(isset($dataDecode->results->ingredients)){

            foreach ($dataDecode->results->ingredients as $ingredient) {
                array_push($fridgeIngredientsId, $ingredient->id);
            }
        }
    
        $response = [];
   

        for ($i=0; $i < count($data) ; $i++) { 

            $arrayInfos = [];
            $arrayIngredients = [];
            $arrayRecipeSteps = [];
            $arrayReviews = [];
            $pertinence = 0;
            
            $allReviews = $reviewController->getAllRecipeReviews($data[$i]['recipe']["infos"]->id);
            $favorite = $favoriteController->getFavorite($data[$i]['recipe']["infos"]->id);
            $review = $reviewController->getReview($data[$i]['recipe']["infos"]->id);
            $endDateIsNew = strtotime($data[$i]['recipe']["infos"]->created_at)  + 1209600;
            $isNew = $endDateIsNew < strtotime(now());
            $missingIngredient = [];


            $recipeInfo = $data[$i]['recipe']["infos"];
            $recipeIngredients = $data[$i]['recipe']["ingredients"];
            $recipeSteps = $data[$i]['recipe']["steps"];
            $totalRecipeIngredient = count($recipeIngredients);
            

            
            foreach($recipeIngredients as $ingredient){


                if(!in_array($ingredient->ingredient_id, $fridgeIngredientsId)){

                   array_push($missingIngredient, [
                    "id" => $ingredient->ingredient_id,
                    "name" => $ingredient->integration_name,
                    "image"=> $ingredient->image === null ? '' : $ingredient->image,
                    "category_id"=> $ingredient->ingredient_category_id,
                    "quantity"=> $ingredient->quantity === null ? 0 : $ingredient->quantity,
                    "unit_name"=> $ingredient->unit === "" ? null : $ingredient->unit
                ]);
                }
                
                array_push($arrayIngredients, [
                    "id" => $ingredient->ingredient_id,
                    "name" => $ingredient->integration_name,
                    "image"=> $ingredient->image === null ? '' : $ingredient->image,
                    "category_id"=> $ingredient->ingredient_category_id,
                    "quantity"=> $ingredient->quantity === null ? 0 : $ingredient->quantity,
                    "unit_name"=> $ingredient->unit === "" ? null : $ingredient->unit
                ]);
            }

            $pertinence = number_format(round(((($totalRecipeIngredient - count($missingIngredient)) * 100) / $totalRecipeIngredient )));

            
            foreach($recipeSteps as $steps){

                array_push($arrayRecipeSteps, [
                    "step_number" => intVal($steps->step_number),
                    "step" => $steps->step,
                ]);
            }

            if (count($allReviews) > 0) {
                $globalRating = 0;
                foreach($allReviews as $review){
                    $globalRating += $review->rating;
                    array_push($arrayReviews, [
                        "rating" => strval($review->rating),
                        "author" => strval($review->nickname),
                        "created_at" => $review->created_at,
                    ]);
                }
                $globalRating = $globalRating/count($allReviews);
    
            }else{
                $globalRating = null;
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
                'pertinence' => round($pertinence),
                'favorite' => $favorite == null ? false : true,
                'user_rating' => $review == null ? null : floatval($review->rating),
                'global_rating' => $globalRating == 0 ? null : floatval($globalRating),
                'is_new' => $isNew,
                'reviews_list' => $arrayReviews,
                "ingredients_list" => $arrayIngredients,
                "ingredients_missing_list" => $missingIngredient,
                "recipe_steps" => $arrayRecipeSteps,
                'created_at' => $recipeInfo->created_at == null ? 0 : $recipeInfo->created_at,
                'updated_at' => $recipeInfo->updated_at == null ? 0 : $recipeInfo->updated_at,
            ]);
        } 
        return $response;
    }
}
