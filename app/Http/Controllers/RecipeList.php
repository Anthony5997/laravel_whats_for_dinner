<?php

namespace App\Http\Controllers;

use App\Models\IngredientRecipe;
use App\Models\Recipe;
use App\Models\RecipeStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecipeList extends Controller
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
        $allRecipes = Recipe::all();
        $recipeComplete = [];
        foreach ($allRecipes as $recipe) {

            $allIngredientRecipe = DB::select("SELECT `ingredient_id`, `integration_name`, `quantity`, `unit` FROM `ingredient_recipes` WHERE `recipe_id` = :id", ["id" =>  $recipe->id]);
            $allStep = DB::select("SELECT `step_number`, `step` FROM `recipe_steps` WHERE `recipe_id` = :id ORDER BY `step_number` ASC", ["id" => $recipe->id]);
            array_push($recipeComplete, ["recipe" => ["infos" => $recipe, "ingredients" => $allIngredientRecipe, "steps" => $allStep]]);
        }
        $response = ["total_results" => count($recipeComplete), "results" => $recipeComplete];
        dd(response()->json($response, 200));
        return response()->json($response, 200);
    }
}
