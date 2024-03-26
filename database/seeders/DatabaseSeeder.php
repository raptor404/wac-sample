<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Author;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\RecipeStep;
use Database\Factories\AuthorFactory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $authors = Author::factory()->count(10)->create();
        $recipes = Recipe::factory()
            ->count(100)
            ->state(new Sequence(
                fn (Sequence $sequence) => ['AuthorID' => Author::all()->random()],
            ))
            ->create();

        $ingredients = RecipeIngredient::factory()
            ->count(1000)
            ->state(new Sequence(fn (Sequence $sequence) => ['RecipeID' => floor($sequence->index/10 ) + 1 ]))
            ->create();

        //creates a list of 10 ingredients per recipe
        $steps = RecipeStep::factory()
            ->count(1000)
            ->state(new Sequence(fn (Sequence $sequence) => ['Order' => ($sequence->index % 10)]))
            ->state(new Sequence(fn (Sequence $sequence) => ['RecipeID' => floor($sequence->index/10 ) + 1 ]))
            ->create();

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
