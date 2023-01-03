<?php

namespace App\Http\Controllers;

use App\Http\Repositories\FavoriteRepository;
use App\Http\Repositories\FridgeRepository;
use App\Http\Repositories\RecipeListRepository;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function getFavorite($recipeId)
    {
        $isFavorite = Favorite::where('user_id', Auth::id())->where("recipe_id", $recipeId)->first();
        return $isFavorite;
  
    }

    /**
     * @OA\Get(
     *      path="/getFavoriteRecipe",
     *      operationId="getFavoriteRecipe",
     *      tags={"Favoris"},

     *      summary="Récupère les recettes favorites de l'utilisateur.",
     *      description="Retourne la liste de recettes favorites de l'utilisateur",
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
    public function getFavoriteRecipe(RecipeListRepository $recipeListRepository, FridgeRepository $fridgeRepository)
    {

        $favoritesRecipes = Favorite::where('user_id', Auth::id())->get();
        $userFridge = $fridgeRepository->getUserFridge();

        $recipeComplete = [];        

        foreach ($favoritesRecipes as $recipe) {
            
            $recipesFound = Recipe::where('id', $recipe->recipe_id)->first();

            $allIngredientRecipe = $recipeListRepository->getAllIngredientsRecipe($recipesFound);
            $allStep = $recipeListRepository->getAllRecipeSteps($recipesFound);
            array_push($recipeComplete, ["recipe" => ["infos" => $recipesFound, "ingredients" => $allIngredientRecipe, "steps" => $allStep]]);
        } 
            
        $sortedRecipes =  $this->sortRecipesByPertinence($recipeComplete, $userFridge);

        $response = ["total_results" => count($recipeComplete), "results" => $sortedRecipes];
        return response()->json($response, 200);
                  
    }

    public function checkFavorite(Request $request, FavoriteRepository $favoriteRepository)
    {
        $recipeId = $request->recipeId;
        $checkFavorite = Favorite::where('user_id', Auth::id())->where("recipe_id", $recipeId)->first();
        
        if ($checkFavorite) {
            $response = $favoriteRepository->deleteRecipeFromFavorite($recipeId);
        }else {
            $response = $favoriteRepository->addRecipeToFavorite($recipeId);
        }
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
