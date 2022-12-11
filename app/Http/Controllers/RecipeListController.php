<?php

namespace App\Http\Controllers;

use App\Http\Repositories\FridgeRepository;
use App\Http\Repositories\RecipeListRepository;
use App\Http\Resources\RecipesList;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getPotentialRecipes(Request $request, RecipeListRepository $recipeListRepository, FridgeRepository $fridgeRepository)
    {

        $allRecipes = Recipe::all();
        $recipeComplete = [];
        $userFridge = $fridgeRepository->getUserFridge();

        foreach ($allRecipes as $recipe) {

            $allIngredientRecipe = $recipeListRepository->getAllIngredientsRecipe($recipe);
            $allStep = $recipeListRepository->getAllRecipeSteps($recipe);
            array_push($recipeComplete, ["recipe" => ["infos" => $recipe, "ingredients" => $allIngredientRecipe, "steps" => $allStep]]);
        }
     
        $sortedRecipes =  $this->sortRecipesByPertinence($recipeComplete, $userFridge);

        $response = ["total_results" => count($recipeComplete), "results" => $sortedRecipes];
        return response()->json($response, 200);
    }

    public function findSpecificRecipes(Request $request, RecipeListRepository $recipeListRepository, FridgeRepository $fridgeRepository){

        $userInput = $request->input;

        $recipesFound = Recipe::where('title', 'like', $userInput . '%')->get();
        $recipeComplete = [];        
        $userFridge = $fridgeRepository->getUserFridge();


        foreach ($recipesFound as $recipe) {

            $allIngredientRecipe = $recipeListRepository->getAllIngredientsRecipe($recipe);
            $allStep = $recipeListRepository->getAllRecipeSteps($recipe);
            array_push($recipeComplete, ["recipe" => ["infos" => $recipe, "ingredients" => $allIngredientRecipe, "steps" => $allStep]]);
        } 
            
            $sortedRecipes =  $this->sortRecipesByPertinence($recipeComplete, $userFridge);

        $response = ["total_results" => count($recipeComplete), "results" => $sortedRecipes];
        return response()->json($response, 200);
    }


    
    public function getRecipeDetail(Request $request, RecipeListRepository $recipeListRepository, FridgeRepository $fridgeRepository){

        $recipeId = $request->id;
        
        $recipesFound = Recipe::where('id', $recipeId)->get();
        $recipeComplete = [];     
        $userFridge = $fridgeRepository->getUserFridge();

        foreach ($recipesFound as $recipe) {

            $allIngredientRecipe = $recipeListRepository->getAllIngredientsRecipe($recipe);
            $allStep = $recipeListRepository->getAllRecipeSteps($recipe);
            array_push($recipeComplete, ["recipe" => ["infos" => $recipe, "ingredients" => $allIngredientRecipe, "steps" => $allStep]]);
        }

        $resourceRecipesList = new RecipesList();

        $response = ["total_results" => count($recipeComplete), "results" => $resourceRecipesList->payload($recipeComplete, $userFridge)];
        return response()->json($response, 200);
      }    

      public function sortRecipesByPertinence($recipeComplete, $userFridge){
        
        $resourceRecipesList = new RecipesList();

        $unsortedRecipes = $resourceRecipesList->payload($recipeComplete, $userFridge);
        $pertinence = array_column($unsortedRecipes, 'pertinence');
        array_multisort($pertinence, SORT_DESC, $unsortedRecipes);
        return $unsortedRecipes;
      }
}
