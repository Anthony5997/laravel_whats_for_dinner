<?php

namespace App\Http\Repositories;

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteRepository{

    protected $favorite;

    public function __construct(Favorite $favorite)
    {
        $this->favorite = $favorite;
    }

    public function deleteRecipeFromFavorite($recipeId){

        DB::table('favorites')->where('favorites.user_id', Auth::id())
                ->where('favorites.recipe_id' , $recipeId)
                ->delete();
                $response = "Retrait réussis";

        return $response;
    }

    public function addRecipeToFavorite($recipeId){

        DB::table('favorites')->insert(
            ['user_id' => Auth::id(),  "recipe_id" => $recipeId]);
            $response = "Ajout réussis";
        return $response;
    }   
 }