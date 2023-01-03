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
        $urls =[
            // "https://www.marmiton.org/recettes/recette_tacos-mexicains_34389.aspx",
            // "https://www.marmiton.org/recettes/recette_spaghetti-bolognaise_19840.aspx",
            // "https://www.marmiton.org/recettes/recette_fajitas-au-poulet_26631.aspx",
            // "https://www.marmiton.org/recettes/recette_brandade-de-morue_12736.aspx",
            // "https://www.marmiton.org/recettes/recette_cordon-bleu_27731.aspx",
            // "https://www.marmiton.org/recettes/recette_lasagnes-au-saumon-et-aux-epinards_14665.aspx",
            // "https://www.marmiton.org/recettes/recette_ramens-au-boeuf_218682.aspx",
            // "https://www.marmiton.org/recettes/recette_poulet-aux-olives-vertes_87592.aspx",
            // "https://www.marmiton.org/recettes/recette_banh-bao-pate-de-viande-vietnamien_61858.aspx",
            // "https://www.marmiton.org/recettes/recette_boulettes-de-viande_84872.aspx",
            // "https://www.marmiton.org/recettes/recette_spaetzle_165933.aspx",
            // "https://www.marmiton.org/recettes/recette_lotte-a-l-armoricaine_16975.aspx",
            // "https://www.marmiton.org/recettes/recette_filet-de-poulet-au-curry_80990.aspx",
            // "https://www.marmiton.org/recettes/recette_poivrons-farcis_94368.aspx",
            // "https://www.marmiton.org/recettes/recette_nachos-au-four_73045.aspx",
            // "https://www.marmiton.org/recettes/recette_chicken-wings_371857.aspx",
            // "https://www.marmiton.org/recettes/recette_boeuf-braise-aux-carottes_13296.aspx",
            // "https://www.marmiton.org/recettes/recette_filet-mignon-en-croute_14407.aspx",
            // "https://www.marmiton.org/recettes/recette_cuisses-de-grenouille-au-beurre-aille-et-persille_24004.aspx",
            // "https://www.marmiton.org/recettes/recette_canard-a-l-orange_36586.aspx",
            // "https://www.marmiton.org/recettes/recette_jarret-de-boeuf-facon-coq-au-vin_167034.aspx",
            // "https://www.marmiton.org/recettes/recette_moules-marinieres-persillees_32408.aspx",
            // "https://www.marmiton.org/recettes/recette_gratin-d-aubergines_30284.aspx",
            // "https://www.marmiton.org/recettes/recette_spaghetti-a-la-carbonara_12249.aspx",
            // "https://www.marmiton.org/recettes/recette_tielle-setoise_17608.aspx",
            // "https://www.marmiton.org/recettes/recette_lasagnes-a-la-ricotta-et-aux-epinards_22045.aspx",
            // "https://www.marmiton.org/recettes/recette_poulet-tandoori-masala_83513.aspx",
            // "https://www.marmiton.org/recettes/recette_rognon-de-boeuf_21697.aspx",
            // "https://www.marmiton.org/recettes/recette_cabillaud-au-four_44399.aspx",
            // "https://www.marmiton.org/recettes/recette_kefta_21805.aspx",
            // "https://www.marmiton.org/recettes/recette_tagliatelles-a-la-carbonara_12993.aspx",
            // "https://www.marmiton.org/recettes/recette_soupe-chinoise-au-poulet_31812.aspx",
            // "https://www.marmiton.org/recettes/recette_chili-sin-carne_371856.aspx",
            // "https://www.marmiton.org/recettes/recette_poelee-de-legumes_168934.aspx",
            // "https://www.marmiton.org/recettes/recette_daube-de-boeuf_20542.aspx",
            // "https://www.marmiton.org/recettes/recette_blanquette-de-poisson_33302.aspx",
            // "https://www.marmiton.org/recettes/recette_pates-au-thon_13754.aspx",
            // "https://www.marmiton.org/recettes/recette_croque-madame_22785.aspx",
            // "https://www.marmiton.org/recettes/recette_poulet-massala_35549.aspx",
            // "https://www.marmiton.org/recettes/recette_nouilles-sautees-aux-legumes_33051.aspx",
            // "https://www.marmiton.org/recettes/recette_saucisses-aux-lentilles_22979.aspx",
            // "https://www.marmiton.org/recettes/recette_magret-de-canard-au-four_80687.aspx",
            // "https://www.marmiton.org/recettes/recette_noix-de-saint-jacques_20420.aspx",(maudit)
            // "https://www.marmiton.org/recettes/recette_falafel-croquettes-de-pois-chiches_23038.aspx",
            // "https://www.marmiton.org/recettes/recette_petit-sale-aux-lentilles_19044.aspx",
            // "https://www.marmiton.org/recettes/recette_tagliatelles-au-saumon-frais_11354.aspx",
            // "https://www.marmiton.org/recettes/recette_rosbeef-au-four-a-l-ail_232964.aspx",
            // "https://www.marmiton.org/recettes/recette_gratin-de-pates-moelleux-facile-et-pas-cher_53247.aspx",
            // "https://www.marmiton.org/recettes/recette_bo-bun-vietnam_26967.aspx",
            // "https://www.marmiton.org/recettes/recette_roti-de-porc-a-la-moutarde-et-au-miel_17178.aspx",
            // "https://www.marmiton.org/recettes/recette_poulet-roti-et-ses-pommes-de-terre_43958.aspx",
            // "https://www.marmiton.org/recettes/recette_joue-de-porc-a-la-biere_36896.aspx",
            // "https://www.marmiton.org/recettes/recette_parmentier-de-confit-de-canard_17048.aspx",
            // "https://www.marmiton.org/recettes/recette_dahl-de-lentilles-corail_166862.aspx",
            // "https://www.marmiton.org/recettes/recette_omelette-nature_21255.aspx",(maudit)
            // "https://www.marmiton.org/recettes/recette_ris-de-veau-aux-champignons_32436.aspx",
            // "https://www.marmiton.org/recettes/recette_tomates-farcies-facile_63622.aspx",
            // "https://www.marmiton.org/recettes/recette_cannelloni-de-viande_45211.aspx",
            // "https://www.marmiton.org/recettes/recette_rouelle-de-porc-a-l-ancienne_19807.aspx",
            // "https://www.marmiton.org/recettes/recette_poulet-curry-et-oignons-facile_13026.aspx",
            // "https://www.marmiton.org/recettes/recette_poule-au-pot-a-l-ancienne_21529.aspx",
            // "https://www.marmiton.org/recettes/recette_andouillette-sauce-moutarde_19759.aspx",
            // "https://www.marmiton.org/recettes/recette_nouilles-chinoises-aux-legumes-et-aux-epices_21482.aspx",
            // "https://www.marmiton.org/recettes/recette_fajitas-au-poulet_26631.aspx",
            // "https://www.marmiton.org/recettes/recette_paupiettes-de-porc-sauce-champignon-creme_172530.aspx",
            // "https://www.marmiton.org/recettes/recette_galettes-de-pomme-de-terre_14072.aspx",
            // "https://www.marmiton.org/recettes/recette_oeufs-brouilles-nature_30569.aspx",
            // "https://www.marmiton.org/recettes/recette_tete-de-veau-a-la-vinaigrette_25659.aspx",
            // "https://www.marmiton.org/recettes/recette_saucisse-de-morteau-au-four_164997.aspx",
            // "https://www.marmiton.org/recettes/recette_boudin-noir-poele-aux-pommes_27785.aspx",
            // "https://www.cuisineaz.com/recettes/calmar-poeles-a-l-ail-et-au-persil-40432.aspx",
            // "https://www.cuisineaz.com/recettes/enchiladas-56332.aspx",
            // "https://www.cuisineaz.com/recettes/chilaquiles-102135.aspx",
            // "https://www.cuisineaz.com/recettes/chekchouka-12419.aspx",
            // // "https://www.cuisineaz.com/recettes/potee-langroise-traditionnelle-115149.aspx",(maudit)
            // "https://www.cuisineaz.com/recettes/ficelle-picarde-traditionnelle-115082.aspx",
            // "https://www.cuisineaz.com/recettes/omelette-du-jardinier-90699.aspx",
            // "https://www.cuisineaz.com/recettes/omelette-parisienne-61966.aspx",
            // "https://www.cuisineaz.com/recettes/parmentier-de-canard-aux-marrons-109051.aspx",
            // "https://www.cuisineaz.com/recettes/empanadas-au-thon-99684.aspx",
            // "https://www.cuisineaz.com/recettes/omelette-aux-epinards-58277.aspx",
            // "https://www.cuisineaz.com/recettes/aligot-traditionnel-114992.aspx",
            // "https://www.cuisineaz.com/recettes/ecrase-de-pommes-de-terre-103294.aspx",
            // // "https://www.cuisineaz.com/recettes/frites-de-carottes-au-four-105798.aspx",(maudit)
            // // "https://www.cuisineaz.com/recettes/polenta-cuite-au-four-81577.aspx",(maudit)
            // "https://www.cuisineaz.com/recettes/shiitake-teriyaki-110587.aspx",
            // "https://www.cuisineaz.com/recettes/galette-de-pommes-de-terre-103350.aspx",
            // "https://www.cuisineaz.com/recettes/cannelloni-a-la-sicilienne-78712.aspx",
            // "https://www.cuisineaz.com/recettes/penne-a-la-creme-65802.aspx",
            // "https://www.cuisineaz.com/recettes/coquillettes-au-cheddar-79457.aspx",
            // "https://www.cuisineaz.com/recettes/pates-a-la-fondue-de-poireaux-61330.aspx",
            // "https://www.cuisineaz.com/recettes/pates-aux-brocolis-et-au-parmesan-53953.aspx",
            // "https://www.cuisineaz.com/recettes/tagliatelles-aux-crevettes-epicees-83018.aspx",
            // "https://www.cuisineaz.com/recettes/cannelloni-aux-epinards-et-a-la-ricotta-13061.aspx",
            // "https://www.cuisineaz.com/recettes/spaghettis-aux-champignons-38156.aspx",
            // "https://www.cuisineaz.com/recettes/ravioles-a-la-sauce-tomate-et-aux-herbes-fraiches-62330.aspx",
            // "https://www.cuisineaz.com/recettes/cannellonis-a-la-viande-et-a-la-sauce-tomate-61077.aspx",
        ];
        foreach ($urls as $url) {
            $response = Http::get("https://api.spoonacular.com/recipes/extract?url=$url&apiKey=$token&analyze=true&forceExtraction=true&includeTaste=true");
            $jsonResponse = $response->json();
            // dd($jsonResponse);
            try {        
                $user = User::findOrFail("f3834b53-e4c7-11ec-a01b-a0cec8e34305");
                $recipeImageName = $this->getRecipeImage($jsonResponse);
                if(!Recipe::where('title',$jsonResponse["title"])->first()){
                    $recipe = $this->insertRecipeInfo($jsonResponse, $user, $recipeImageName);
                    echo "<h3>Nouvelle Recette '$recipe->title' Ajouter</h3>";
                    $this->insertRecipeSteps($jsonResponse, $recipe);
                }else{
                    $recipe = Recipe::where('title',$jsonResponse["title"])->first();
                    echo "<h3>Recette '$recipe->title' déjà existante</h3>";
                }
                $this->insertAllIngredientsAndIngredientRecipe($jsonResponse['extendedIngredients'], $recipe);

            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
            echo "<hr>";
            echo "<hr>";
            echo "<hr>";
        }

    }
    
    public function formatStringWithNoAccents($entre)
    {
        $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');

        $entre = str_replace($search, $replace, $entre);
        return $entre;
    }

    public function addCategorieToIngredient($entre)
    {
        switch (strtolower($entre['aisle'])) {
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
        return $ingredientCategorie;
    }

    public function getRecipeImage($jsonResponse)
    {
        if($jsonResponse["image"]){

            $recipeImage = $jsonResponse["image"];
            // $randomNumber = rand(0, 99999);
            $image = file_get_contents("$recipeImage");
            $recipeImageName = $this->formatStringWithNoAccents($jsonResponse["title"]);
            $recipeImageName = utf8_encode(strtolower(str_replace([" ", "'", ":", "@","\""], "", $recipeImageName)));
            if(strlen($recipeImageName) >= 15){
                $recipeImageName = substr($recipeImageName, 0, strlen($recipeImageName)). ".jpeg";
            }else{
                $recipeImageName = $recipeImageName. ".jpeg"; 
            }
            file_put_contents(public_path("images\\recipe\\$recipeImageName"), $image);
            echo "<p>- Image Recette ajouté  </p>";
    
        }else{
            echo "<p>- Aucune Image Recette ajouté  </p>";
            $recipeImageName ="default_recipe.jpeg";
        }
        return $recipeImageName;
    }

    public function getIngredientImage($ingredientInRecipe)
    {
        if($ingredientInRecipe['image']){

            $ingredientImageName = $ingredientInRecipe['image'];
            $image = file_get_contents("https://spoonacular.com/cdn/ingredients_100x100/$ingredientImageName");

            if(str_contains($ingredientInRecipe['image'], '.jpg')){
                $ingredientImageName = utf8_encode(strtolower(str_replace(".jpg", ".jpeg", $ingredientInRecipe['image'])));
                $ingredientImageName = $this->formatStringWithNoAccents($ingredientImageName);
            }

            file_put_contents(public_path("images\ingredients\\$ingredientImageName"), $image);
            
            echo "<p>- Image Ingrédient '$ingredientImageName' ajouté  </p>";
        }else{
            $ingredientImageName = "default_ingredient.jpeg";
            echo "<p>- Aucune image Ingrédient ajouté </p>";
        }

        return $ingredientImageName;
    }

    public function insertRecipeSteps($jsonResponse, $recipe)
    {
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
    }

    public function insertRecipeInfo($jsonResponse, $user, $recipeImageName)
    {
        $recipe = new Recipe();
            $recipe->title = $jsonResponse["title"];
            $recipe->summary = $jsonResponse["title"];
            $recipe->image = "images/recipe/".$recipeImageName;
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
        return $recipe;
    }

    public function insertIngredientRecipe($recipe, $ingredient, $ingredientInRecipe)
    {
        $ingredientRecipe = new IngredientRecipe();
            $ingredientRecipe->recipe_id = $recipe->id;
            $ingredientRecipe->ingredient_id = $ingredient->id;
            $ingredientRecipe->integration_name = $ingredientInRecipe['original'];
            $ingredientRecipe->quantity = $ingredientInRecipe['amount'];
            $ingredientRecipe->unit = $ingredientInRecipe['unit'];
            $ingredientRecipe->save();
    }

    public function insertIngredient($ingredientName, $ingredientImageName, $ingredientCategorie)
    {
        $ingredient = new Ingredient();
        $ingredient->name = $ingredientName;
        $ingredient->image = 'images/ingredients/'.$ingredientImageName;
        $ingredient->ingredient_category_id = $ingredientCategorie;
        $ingredient->save();
        return $ingredient;
    }

    public function insertAllIngredientsAndIngredientRecipe($allingredientInRecipe, $recipe)
    {
        foreach ($allingredientInRecipe as $ingredientInRecipe) {

            echo "<hr>";        

            $ingredientName = $this->formatIngredientName($ingredientInRecipe);

            if(!Ingredient::where('name',$ingredientName)->first()){

                $ingredientImageName = $this->getIngredientImage($ingredientInRecipe);
                $ingredientCategorie = $this->addCategorieToIngredient($ingredientInRecipe);

                $ingredient = $this->insertIngredient($ingredientName, $ingredientImageName, $ingredientCategorie);
                echo "<h3>Nouvel Ingrédient '$ingredient->name' Ajouter</h3>";
            }else{
                $ingredient = Ingredient::where('name',$ingredientName)->first();
                echo "<h3>Ingrédient '$ingredient->name' déjà existant</h3>";
            }

            if(!IngredientRecipe::where('recipe_id',$recipe->id)->where('ingredient_id',$ingredient->id)->first()){
                $this->insertIngredientRecipe($recipe, $ingredient, $ingredientInRecipe);
                echo "<h3>Nouvel Ingrédient/Recette Ajouter</h3>";
            }else{
                IngredientRecipe::where('recipe_id',$recipe->id)->where('ingredient_id',$ingredient->id)->first();
                echo "<h3> Ingrédient/Recette  Déjà Existant</h3>";
            }
        }
    }

    public function formatIngredientName($ingredientInRecipe)
    {
        if(str_contains($ingredientInRecipe['originalName'], 'de ')){
            $ingredientName = explode("de ", $ingredientInRecipe['originalName'], 2 );
            $ingredientName = $ingredientName[1];
    
        }else{
            $ingredientName = $ingredientInRecipe['originalName'];
        }
        return $ingredientName;
    }

    
   

    
   

}