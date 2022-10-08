<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipesList;
use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
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
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        //
    }

    public function getFavorite($recipeId)
    {
        $isFavorite = Favorite::where('user_id', Auth::id())->where("recipe_id", $recipeId)->first();
        return $isFavorite;
  
    }

    public function getFavoriteRecipe()
    {

        $favoritesRecipes = Favorite::where('user_id', Auth::id())->get();

        $recipeComplete = [];        

        foreach ($favoritesRecipes as $recipe) {
            
            $recipesFound = Recipe::where('id', $recipe->recipe_id)->first();

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
                WHERE recipe_id = :id", ["id" =>  $recipesFound->id]);
            $allStep = DB::select("SELECT `step_number`, `step` FROM `recipe_steps` WHERE `recipe_id` = :id ORDER BY `step_number` ASC", ["id" => $recipesFound->id]);
            array_push($recipeComplete, ["recipe" => ["infos" => $recipesFound, "ingredients" => $allIngredientRecipe, "steps" => $allStep]]);
            } 
            
            $resourceRecipesList = new RecipesList();

            $unsortedRecipes = $resourceRecipesList->payload($recipeComplete);
            $pertinence = array_column($unsortedRecipes, 'pertinence');
            array_multisort($pertinence, SORT_DESC, $unsortedRecipes);
            $sortedRecipes =  $unsortedRecipes;

        $response = ["total_results" => count($recipeComplete), "results" => $sortedRecipes];
        return response()->json($response, 200);
                  
    }

    public function checkFavorite(Request $request)
    {
        $recipeId = $request->recipeId;

        $checkFavorite = Favorite::where('user_id', Auth::id())->where("recipe_id", $recipeId)->first();

        
        if ($checkFavorite) {
        
                DB::table('favorites')->where('favorites.user_id', Auth::id())
                ->where('favorites.recipe_id' , $recipeId)
                ->delete();
                $response = "Retrait réussis";
            }else {
                DB::table('favorites')->insert(
                    ['user_id' => Auth::id(),  "recipe_id" => $recipeId]);
                    $response = "Ajout réussis";
            }
            
            return response()->json($response, 200);
  
    }

    public function removeFromFavorite(Request $request)
    {
        $recipeId = $request->recipeId;

        $checkFavorite = Favorite::where('user_id', Auth::id())->where("recipe_id", $recipeId)->first();
        $response = "Déjà en favoris";

        if ($checkFavorite) {

            DB::table('favorites')->insert(
                ['user_id' => Auth::id(),  "recipe_id" => $recipeId]);
                $response = "Ajout réussis";
            }
            
            return response()->json($response, 200);
  
    }

}
