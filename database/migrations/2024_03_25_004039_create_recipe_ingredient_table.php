<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('RecipeIngredient', function (Blueprint $table) {
            $table->id('RecipeIngredient');
            $table->foreignId('RecipeID');
            $table->mediumText('Text');
            $table->timestamps();
            $table->fullText('Text', 'IDX_FT_RecipeIngredientText');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('RecipeIngredient');
    }
};
