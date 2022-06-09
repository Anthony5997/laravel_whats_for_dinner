<?php

namespace App\Models;

use App\Http\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory, Uuids;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'summary',
        'ready_in_minutes',
        'servings',
        'preparation_minutes',
        'cooking_minutes',
        'recipe_picture',
        'image',
        'vegetarian',
        'vegan',
        'glute_free',
        'dairy_free',
        'user_id',
    ];


}
