<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipesList;
use App\Http\Resources\RecipeRessources;
use App\Models\IngredientRecipe;
use App\Models\Recipe;
use App\Models\RecipeStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPotentialRecipes(Request $request)
    {

        // $fridgeIngredientsId = [];
        // $userFridge = DB::select("SELECT ingredient_categories.*, ingredients.*, 
        // ingredients_fridge.id as ingredient_fridge_id,
        // ingredients_fridge.quantity,
        // ingredients_fridge.unit_id,
        // units.unit_name,
        // fridges.id as fridge_id
        // FROM fridges
        // INNER JOIN ingredients_fridge ON ingredients_fridge.fridge_id = fridges.id
        // INNER JOIN ingredients ON ingredients.id = ingredients_fridge.ingredient_id
        // INNER JOIN ingredient_categories ON ingredient_categories.id = ingredients.ingredient_category_id
        // INNER JOIN units ON units.id = ingredients_fridge.unit_id
        // WHERE fridges.user_id = :id", ['id' => Auth::id()] );

        // foreach ($userFridge as $ingredient) {
        //   array_push($fridgeIngredientsId, $ingredient->id);  
        // }

        // dd($fridgeIngredientsId);

        $allRecipes = Recipe::all();
        $recipeComplete = [];
        foreach ($allRecipes as $recipe) {

            $allIngredientRecipe = DB::select(
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
            $allStep = DB::select("SELECT `step_number`, `step` FROM `recipe_steps` WHERE `recipe_id` = :id ORDER BY `step_number` ASC", ["id" => $recipe->id]);
            array_push($recipeComplete, ["recipe" => ["infos" => $recipe, "ingredients" => $allIngredientRecipe, "steps" => $allStep]]);
        }
        
        $resourceRecipesList = new RecipesList();

        $response = ["total_results" => count($recipeComplete), "results" => $resourceRecipesList->payload($recipeComplete)];
        return response()->json($response, 200);
    }

    public function findSpecificRecipes(Request $request){

        $userInput = $request->input;

        $recipesFound = Recipe::where('title', 'like', $userInput . '%')->get();
        $recipeComplete = [];        

        foreach ($recipesFound as $recipe) {

            $allIngredientRecipe = DB::select(
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
            $allStep = DB::select("SELECT `step_number`, `step` FROM `recipe_steps` WHERE `recipe_id` = :id ORDER BY `step_number` ASC", ["id" => $recipe->id]);
            array_push($recipeComplete, ["recipe" => ["infos" => $recipe, "ingredients" => $allIngredientRecipe, "steps" => $allStep]]);
            } 
            
            $resourceRecipesList = new RecipesList();

        $response = ["total_results" => count($recipeComplete), "results" => $resourceRecipesList->payload($recipeComplete)];
        return response()->json($response, 200);
    }


    
    public function getRecipeDetail(Request $request){

        $recipeId = $request->id;
        
        $recipesFound = Recipe::where('id', $recipeId)->get();
        $recipeComplete = [];     


        foreach ($recipesFound as $recipe) {
            $allIngredientRecipe = DB::select(
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
            $allStep = DB::select("SELECT `step_number`, `step` FROM `recipe_steps` WHERE `recipe_id` = :id ORDER BY `step_number` ASC", ["id" => $recipe->id]);
            array_push($recipeComplete, ["recipe" => ["infos" => $recipe, "ingredients" => $allIngredientRecipe, "steps" => $allStep]]);
        }

        $resourceRecipesList = new RecipesList();
        $response = ["total_results" => count($recipeComplete), "results" => $resourceRecipesList->payload($recipeComplete, [])];
        return response()->json($response, 200);
      }

    // public function addRecipeToFavorie(Request $request){

    //     $userInput = $request->input;

    //     $response = ["total_results" => [], "results" => []];
    //     return response()->json($response, 200);
    // }
    
}
