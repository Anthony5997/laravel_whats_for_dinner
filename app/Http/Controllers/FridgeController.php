<?php

namespace App\Http\Controllers;

use App\Models\Fridge;
use App\Http\Resources\Fridge as ResourcesFridge;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FridgeController extends Controller
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
    public function destroy($idFridge , $idIngredient)
    {
        //
    }


      public function getFridgeIngredientsByUser(Request $request){

        
        // $userFridge = Fridge::where('user_id', [$id])->get();
        $userFridge = DB::table('fridges')->join('ingredients', "fridges.ingredient_id", "=" , "ingredients.id")->join('ingredient_categories', "ingredients.ingredient_category_id", "=" , "ingredient_categories.id")->where("fridges.user_id", "=", $request->id)->get();

        $currentUserFridge = [];

        $response = ["total_results" => count($userFridge), "results" => $userFridge];
        return response()->json($response, 200);
      }






      public function removeIngredientFromFridge(Request $request)
      {
            $idFridge = $request->idFridge;
            $idIngredient = $request->idIngredient;

        try {
            $userFridge = DB::table('fridges')
            ->where('fridges.id', "=" , $idFridge)
            ->where('fridges.ingredient_id', "=" , $idIngredient)->delete();
        } catch (\Throwable $th) {

        }
        $response = "Suppression réussis";
        return response()->json($response, 200);
      }


      public function addIngredientIntoFridge(Request $request)
      {

            $idUser = $request->idUser;
            $idIngredient = $request->idIngredient;
            dd($idUser, $idIngredient);
            try {
            // $userId = $request->userId;
                $userFridge = DB::table('fridges')->insert(
                ['user_id' => $idUser, 'ingredient_id' => $idIngredient]);
            } catch (\Throwable $th) {

            }

        $response = "Ajout réussis";
        return response()->json($response, 200);
      }
}
