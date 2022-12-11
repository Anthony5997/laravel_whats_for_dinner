<?php

namespace App\Http\Controllers;

use App\Http\Resources\IngredientsFridge;
use App\Http\Repositories\FridgeRepository;
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

    public function getFridgeIngredientsByUser(FridgeRepository $fridgeRepository){

        $userFridge = $fridgeRepository->getUserFridge();
        $resourceIngredientsFrigde = new IngredientsFridge();
        $results =[];
        
        if (count($userFridge) > 0) {
            $results = ["id" => $userFridge[0]->fridge_id, "ingredients" => $resourceIngredientsFrigde->payload($userFridge)];
        }
        return response(["total_results" => count($userFridge), "results" => $results], 200);
    }
     
      
      public function addIngredientIntoFridge(Request $request, FridgeRepository $fridgeRepository)
      {
        $fridgeId = $request->fridgeId;
        $ingredientId = $request->ingredientId;
        $quantity = $request->quantity;
        $unit = $request->unit;

        $ingredientFound = $fridgeRepository->getOneIngredientFridge($fridgeId, $ingredientId);
        $response = "En attente";
        
        if($ingredientFound == null){
            try {
                $response = $fridgeRepository->insertIngredientFridge($fridgeId, $ingredientId, $quantity, $unit);  
            } catch (\Throwable $th) {
                $response = "Une erreur est survenue. Echec de l'insertion.";
            }
            return response()->json($response, 200);
        }else{
            if($unit == $ingredientFound->unit_id){
                try {
                    $response = $fridgeRepository->insertNewQuantityIngredientFridge($fridgeId, $ingredientId,$ingredientFound, $quantity);
                } catch (\Throwable $th) {
                $response = "Echec d'ajout d'une nouvelle quantitée";
                }
            }else{
                $response = "Echec de l'ajout. L'unitée de mesure séléctionnée n'est pas la même que celle contenu dans votre fridgo.";
            }
        }
        return response()->json($response, 200);
    }

    public function updateIngredientIntoFridge(Request $request, FridgeRepository $fridgeRepository)
    {
      $fridgeId = $request->fridgeId;
      $ingredientId = $request->ingredientId;
      $quantity = $request->quantity;
      $unit = $request->unit;

      $ingredientFound = $fridgeRepository->getOneIngredientFridge($fridgeId, $ingredientId);
      $response = "En attente";
      
        if($unit == $ingredientFound->unit_id){
              try {
                $response = $fridgeRepository->updateQuantityIngredientFridge($fridgeId, $ingredientId,$ingredientFound, $quantity);
              } catch (\Throwable $th) {
                $response = "Echec de modification de la quantitée";
              }
        }else{
            try {
                $response = $fridgeRepository->updateQuantityAndUnitIngredientFridge($fridgeId, $ingredientId,$ingredientFound, $quantity, $unit);
            } catch (\Throwable $th) {
                $response = "Echec de modification de la quantitée et de l'unitée";
            }
          }
      return response()->json($response, 200);
  }


        public function deleteIngredientFromFridge(Request $request, FridgeRepository $fridgeRepository)
        {
            $fridgeId = $request->fridgeId;
            $ingredientId = $request->ingredientId;
            try {
                $response = $fridgeRepository->deleteIngredientFridge($fridgeId, $ingredientId);
            } catch (\Throwable $th) {
                $response = "Une erreur est survenue, suppression échouée.";
            }
            return response()->json($response, 200);
        }


        public function deleteAllIngredientsFromFridge(Request $request, FridgeRepository $fridgeRepository)
        {
            $fridgeId = $request->fridgeId;
            try {
                $response = $fridgeRepository->deleteAllIngredientFridge($fridgeId);
            } catch (\Throwable $th) {
                $response = "Une erreur est survenue, suppression des ingrédients échouée.";
            }
            return response()->json($response, 200);
        }
    }
    