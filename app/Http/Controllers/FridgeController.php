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

        /**
     * @OA\Get(
     *      path="/getFridgeIngredientsByUser",
     *      operationId="getFridgeIngredientsByUser",
     *      tags={"Frigo"},

     *      summary="Récupère la liste d'ingrédients du frigo utilisateur.",
     *      description="Retourne un frigo utilisateur & sa liste complète d'ingrédients",
     *      @OA\Response(
     *          response=200,
     *          description="Opération réussis",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Non authentifié",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Accès refusé"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Requête erronée"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="Aucun résultat"
     *   ),
     *  )
     */
    public function getFridgeIngredientsByUser(FridgeRepository $fridgeRepository){

        $userFridge = $fridgeRepository->getUserFridge();
        $resourceIngredientsFrigde = new IngredientsFridge();
        $results =[];
        
        if (count($userFridge) > 0) {
            $results = ["id" => $userFridge[0]->fridge_id, "ingredients" => $resourceIngredientsFrigde->payload($userFridge)];
        }
        return response(["total_results" => count($userFridge), "results" => $results], 200);
    }
     
    
    /**
     * @OA\Post(
     *      path="/addIngredientIntoFridge",
     *      operationId="addIngredientIntoFridge",
     *      tags={"Frigo"},

     *      summary="Ajout un ingrédient au frigo utilisateur.",
     *      description="Retourne une réponse et un status 200 en cas de succès.",
     *      @OA\Response(
     *          response=200,
     *          description="Opération réussis",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Non authentifié",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Accès refusé"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Requête erronée"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="Aucun résultat"
     *   ),
     *  )
     */
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

    
            /**
     * @OA\Patch(
     *      path="/updateIngredientIntoFridge",
     *      operationId="updateIngredientIntoFridge",
     *      tags={"Frigo"},

     *      summary="Met à jour un ingrédient dans le frigo utilisateur.",
     *      description="Retourne une réponse et un status 200 en cas de succès. Permet de modifier la quantité et l'unité d'un ingrédient dans le frigo de l'utilisateur.",
     *      @OA\Response(
     *          response=200,
     *          description="Opération réussis",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Non authentifié",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Accès refusé"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Requête erronée"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="Aucun résultat"
     *   ),
     *  )
     */
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


       /**
     * @OA\Delete(
     *      path="/deleteIngredientFromFridge",
     *      operationId="deleteIngredientFromFridge",
     *      tags={"Frigo"},

     *      summary="Retire un ingrédient au frigo utilisateur.",
     *      description="Retourne une réponse et un status 200 en cas de succès.",
     *      @OA\Response(
     *          response=200,
     *          description="Opération réussis",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Non authentifié",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Accès refusé"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Requête erronée"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="Aucun résultat"
     *   ),
     *  )
     */
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


        /**
     * @OA\Delete(
     *      path="/deleteAllIngredientsFromFridge",
     *      operationId="deleteAllIngredientsFromFridge",
     *      tags={"Frigo"},

     *      summary="Retire tous les ingrédients du frigo utilisateur.",
     *      description="Retourne une réponse et un status 200 en cas de succès.",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
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
    