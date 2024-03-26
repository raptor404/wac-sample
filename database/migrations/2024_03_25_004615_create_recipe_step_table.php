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
        Schema::create('RecipeStep', function (Blueprint $table) {
            $table->id('RecipeStepID');
            $table->foreignId('RecipeID');
            $table->integer('Order');
            $table->text('Text');
            $table->timestamps();
            $table->fullText('Text','IDX_FT_RecipeStepText');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('RecipeStep');
    }
};
