<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\IngredientRecipe;
use App\Models\Recipe;
use App\Models\RecipeStep;
use App\Models\User;
use Illuminate\Support\Facades\Http;
class RecipeController extends Controller
{

    public function index(){

    }

    public function getApiInfos(){

        $token = "c2ae3ed4529e43528e15d405c8e2bfa9";
        $url ="https://www.marmiton.org/recettes/recette_couscous-tunisien-traditionnel_94946.aspx";
        $response = Http::get("https://api.spoonacular.com/recipes/extract?url=$url&apiKey=$token&analyze=true&forceExtraction=true&includeTaste=true");
        $jsonResponse = $response->json();
        
        try {        
            $user = User::findOrFail("f3834b53-e4c7-11ec-a01b-a0cec8e34305");
            //  IMAGE RECETTE
            if($jsonResponse["image"]){

                $recipeImage = $jsonResponse["image"];
                $randomNumber = rand(0, 99999);
                $image = file_get_contents("$recipeImage");
                $recipeImageName = $this->formatStringWithNoAccents($jsonResponse["title"]);
                $recipeImageName = utf8_encode(strtolower(str_replace([" ", "'", ":", "@","\""], "", $recipeImageName)));
                if(strlen($recipeImageName) >= 15){
                    $recipeImageName = substr($recipeImageName, 0, 15). ".jpeg";
                }else{
                    $recipeImageName = $recipeImageName. ".jpeg"; 
                }
                file_put_contents(public_path("assets\\recipe\\$recipeImageName"), $image);
                echo "<p>- Image Recette ajouté  </p>";

            }else{
                $recipeImageName ="default_recipe.jpeg";
                echo "<p>- Aucune Image Recette ajouté  </p>";

            }
            // FIN IMAGE RECETTE


            if(!Recipe::where('title',$jsonResponse["title"])->first()){
                $recipe = new Recipe();
                $recipe->title = $jsonResponse["title"];
                $recipe->summary = $jsonResponse["title"];
                $recipe->image = $recipeImageName;
                $recipe->ready_in_minutes = $jsonResponse["readyInMinutes"];
                $recipe->servings = $jsonResponse["servings"];
                $recipe->preparation_minutes = $jsonResponse["preparationMinutes"];
                $recipe->cooking_minutes = $jsonResponse["cookingMinutes"];
                $recipe->vegetarian = $jsonResponse["vegetarian"];
                $recipe->vegan = $jsonResponse["vegan"];
                $recipe->gluten_free = $jsonResponse["glutenFree"];
                $recipe->dairy_free = $jsonResponse["dairyFree"];
                $recipe->user_id = $user->id;

                $recipe->save();


            echo "<h3>Nouvelle Recette '$recipe->title' Ajouter</h3>";

            $stepNumber = 1;
            foreach($jsonResponse["analyzedInstructions"] as $steps){
                
                foreach($steps["steps"] as $item){

                    $recipeStep = new RecipeStep();
                    $recipeStep->recipe_id = $recipe->id;
                    $recipeStep->step_number = $stepNumber;
                    $recipeStep->step = $item['step'];
                    $recipeStep->save();
                    echo "<p>Etape n° : " . $stepNumber . " Enregistré </p>";
                    $stepNumber += 1;
                }
            }

            }else{
                $recipe = Recipe::where('title',$jsonResponse["title"])->first();
                echo "<h3>Recette '$recipe->title' déjà existante</h3>";
            }

            foreach ($jsonResponse['extendedIngredients'] as $ingredientInRecipe) {

                echo "<hr>";        

                if(str_contains($ingredientInRecipe['originalName'], 'de ')){
                    $ingredientName = explode("de ", $ingredientInRecipe['originalName'], 2 );
                    $ingredientName = $ingredientName[1];

                }else{
                    $ingredientName = $ingredientInRecipe['originalName'];
                }


                if(!Ingredient::where('name',$ingredientName)->first()){

                    // // IMAGE INGREDIENT
                    if($ingredientInRecipe['image']){

                        $ingredientImageName = $ingredientInRecipe['image'];
                        $image = file_get_contents("https://spoonacular.com/cdn/ingredients_100x100/$ingredientImageName");

                        if(str_contains($ingredientInRecipe['image'], '.jpg')){

                            $ingredientImageName = utf8_encode(strtolower(str_replace(".jpg", ".jpeg", $ingredientInRecipe['image'])));
                            $ingredientImageName = $this->formatStringWithNoAccents($ingredientImageName);
                        }

                        file_put_contents(public_path("assets\ingredients\\$ingredientImageName"), $image);
                        
                        echo "<p>- Image Ingrédient '$ingredientImageName' ajouté  </p>";
                    }else{
                        $ingredientImageName = "default_ingredient.jpeg";
                        echo "<p>- Aucune image Ingrédient ajouté </p>";
                    }
                    // // FIN IMAGE INGREDIENT

                    // INGREDIENT CATEGORIE
                    switch (strtolower($ingredientInRecipe['aisle'])) {
                        case 'meat':
                            $ingredientCategorie = 1;
                            break;
                        case 'cheese':
                            $ingredientCategorie = 7;
                            break;
                        case 'spices and seasonings':
                            $ingredientCategorie = 9;
                            break;
                        case 'condiments':
                            $ingredientCategorie = 3;
                            break;
                        case 'alcoholic beverages':
                            $ingredientCategorie = 10;
                            break;
                        case 'seafood':
                            $ingredientCategorie = 2;
                            break;
                        case 'milk, eggs, other dairy':
                            $ingredientCategorie = 7;
                            break;
                        case 'canned and jarred':
                            $ingredientCategorie = 11;
                            break;
                        case 'produce':
                            $ingredientCategorie = 11;
                            break;
                        case 'produce;baking':
                            $ingredientCategorie = 11;
                            break;
                        case 'baking':
                            $ingredientCategorie = 11;
                            break;   
                        
                        default:
                            $ingredientCategorie = 11;
                            echo "<p>Aliment non catégorisé</p>";
                            break;
                    }

                // FIN INGREDIENT CATEGORIE

                    $ingredient = new Ingredient();
                    $ingredient->name = $ingredientName;
                    $ingredient->image = $ingredientImageName;
                    $ingredient->ingredient_category_id = $ingredientCategorie;
        
                    $ingredient->save();
                    echo "<h3>Nouvel Ingrédient '$ingredient->name' Ajouter</h3>";
                }else{
                    $ingredient = Ingredient::where('name',$ingredientName)->first();
                    echo "<h3>Ingrédient '$ingredient->name' déjà existant</h3>";
                }

                if(!IngredientRecipe::where('recipe_id',$recipe->id)->where('ingredient_id',$ingredient->id)->first()){

                    $ingredientRecipe = new IngredientRecipe();
                    $ingredientRecipe->recipe_id = $recipe->id;
                    $ingredientRecipe->ingredient_id = $ingredient->id;
                    $ingredientRecipe->integration_name = $ingredientInRecipe['original'];
                    $ingredientRecipe->quantity = $ingredientInRecipe['amount'];
                    $ingredientRecipe->unit = $ingredientInRecipe['unit'];
                    $ingredientRecipe->save();
                    echo "<h3>Nouvel Ingrédient/Recette Ajouter</h3>";
                }else{
                    $ingredientRecipe = IngredientRecipe::where('recipe_id',$recipe->id)->where('ingredient_id',$ingredient->id)->first();
                    echo "<h3> Ingrédient/Recette  Déjà Existant</h3>";
                }

            }

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }


    
    public function formatStringWithNoAccents($entre)
    {
        $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');

        $entre = str_replace($search, $replace, $entre);
        return $entre;
    }


    public function getAllIngredients(){

      $allIngredients = Ingredient::all();

      $response = ["total_results" => count($allIngredients), "results" => $allIngredients];
        return response()->json($response, 200);
    }
}