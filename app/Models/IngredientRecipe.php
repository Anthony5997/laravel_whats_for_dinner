<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientRecipe extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'recipes_id',
        'ingredients_id',
        'integration_name',
        'quantity',
        'unit',
    ];
}
