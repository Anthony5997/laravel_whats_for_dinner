<?php

namespace App\Models;

use App\Http\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientRecipe extends Model
{
    use HasFactory, Uuids;
    
    public $timestamps = false;

    protected $fillable = [
        'recipes_id',
        'ingredients_id',
        'integration_name',
        'quantity',
        'unit',
    ];
}
