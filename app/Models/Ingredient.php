<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    public function ingredient(){
        return $this->hasOne(IngredientCategory::class, 'id', 'ingredient_category_id');
    }

    protected $fillable = [
        'name',
        'image',
        'ingredient_category_id',
    ];
}
