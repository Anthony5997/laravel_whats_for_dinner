<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 100)->unique();
            $table->string('summary', 255);
            $table->string('image', 255);
            $table->integer('ready_in_minutes');
            $table->integer('servings');
            $table->integer('preparation_minutes');
            $table->integer('cooking_minutes');
            $table->boolean('vegetarian')->default(false);
            $table->boolean('vegan')->default(false);
            $table->boolean('gluten_free')->default(false);
            $table->boolean('dairy_free')->default(false);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->foreignIdFor(User::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
