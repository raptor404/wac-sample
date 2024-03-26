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
        Schema::create('Recipe', function (Blueprint $table) {
            $table->id('RecipeID');
            $table->foreignId('AuthorID');
            $table->string('Name',255);
            $table->text('Description');
            $table->string('Slug',255)->unique();
            $table->timestamps();
            $table->fullText('Name','IDX_FT_RecipeName');
            $table->fullText('Description', 'IDX_FT_RecipeDescription');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Recipe');
    }
};
