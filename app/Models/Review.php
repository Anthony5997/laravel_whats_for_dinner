<?php
namespace App\Models;

use App\Http\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'users_id',
        'recipes_id',
        'rating',
    ];
}
