<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewsController extends Controller
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
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }

    public function getReview($recipeId)
    {
        $isReview = Review::where('user_id', Auth::id())->where("recipe_id", $recipeId)->first();
        return $isReview;
  
    }

    public function getAllRecipeReviews($recipeId)
    {
        $allRecipeReviews = Review::where("recipe_id", $recipeId)->join('users', 'reviews.user_id', '=', 'users.id')->get();

        return $allRecipeReviews;
  
    }

    public function addReview(Request $request)
    {
        $recipeId = $request->recipeId;
        $rating = $request->rating;

        $checkReview = $this->getReview($recipeId);

        
        if ($checkReview == null) {
        
            DB::table('reviews')->insert(
                ['rating' => $rating,'user_id' => Auth::id(), "recipe_id" => $recipeId]);
                $response = "Avis posté.";
            }else {
                $response = "Déjà noté.";
            }
            
            return response()->json($response, 200);
  
    }

}
