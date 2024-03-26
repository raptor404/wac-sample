<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RecipeFactory extends Factory
{

    public function definition(): array
    {
        return [
            'Name' => fake()->text(15) . ' ' . fake()->name() . ' ' . fake()->text(15),
            'Description' => fake()->text(400),
            'AuthorID' => null,
            'Slug' => preg_replace('/\s+/', '-',fake()->unique()->text(50))
        ];
    }

}
