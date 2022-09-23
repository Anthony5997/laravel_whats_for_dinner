<?php

namespace App\Http\Controllers;

use App\Http\Resources\Ingredient as ResourcesIngredient;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
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
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function show(Ingredient $ingredient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingredient $ingredient)
    {
        //
    }


    public function getAllIngredients(){

        $allIngredients = ResourcesIngredient::collection(Ingredient::all());

        $response = ["total_results" => count($allIngredients), "results" => $allIngredients];
        return response()->json($response, 200);
      }

      public function getIngredientsByCategory(Request $request, $id){
        
        $allIngredientsInCategory = ResourcesIngredient::collection(Ingredient::where('ingredient_category_id', [$id])->get());

        $response = ["total_results" => count($allIngredientsInCategory), "results" => $allIngredientsInCategory];
        return response()->json($response, 200);
      }

      public function findIngredients(Request $request){

          $ingredientCategoryId= $request->id;
          $userInput = $request->input;
          
          $ingredientsSearch = ResourcesIngredient::collection(Ingredient::where('ingredient_category_id', [$ingredientCategoryId])->where('name', 'like', $userInput . '%')->get());

        $response = ["total_results" => count($ingredientsSearch), "results" => $ingredientsSearch];
        return response()->json($response, 200);
    }

}
