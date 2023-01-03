<?php

use App\Models\Fridge;
use App\Models\Ingredient;
use App\Models\Unit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientsFridgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients_fridge', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fridge::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Ingredient::class)->constrained()->onDelete('cascade');
            $table->integer('quantity')->nullable();
            $table->foreignIdFor(Unit::class);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients_fridge');
    }
}
