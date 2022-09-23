<?php

namespace App\Http\Controllers;

use App\Http\Resources\IngredientCategory as ResourcesIngredientCategory;
use App\Models\IngredientCategory;
use Illuminate\Http\Request;

class IngredientCategoryController extends Controller
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
     * @param  \App\Models\IngredientCategory  $ingredientCategory
     * @return \Illuminate\Http\Response
     */
    public function show(IngredientCategory $ingredientCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IngredientCategory  $ingredientCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IngredientCategory $ingredientCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IngredientCategory  $ingredientCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(IngredientCategory $ingredientCategory)
    {
        //
    }


    
    public function getAllIngredientCategories(){

        $allIngredientCategories = ResourcesIngredientCategory::collection(IngredientCategory::all());

        $response = ["total_results" => count($allIngredientCategories), "results" => $allIngredientCategories];
        return response()->json($response, 200);
    }

    public function findCategory(Request $request){

        $userInput = $request->input;
        
        $categorySearch = ResourcesIngredientCategory::collection(IngredientCategory::where('category_name', 'like', '%' . $userInput . '%')->get());

      $response = ["total_results" => count($categorySearch), "results" => $categorySearch];
      return response()->json($response, 200);
  }





}
