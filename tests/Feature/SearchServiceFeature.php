<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchServiceFeature extends TestCase
{
    public function test_get_recipe_api_base():void
    {
        $response = $this->get('/api/recipe');
        $response->assertStatus(200);

    }

    public function test_can_search_no_input(): void
    {
        $response = $this->get('/api/recipe/search');
        $response->assertStatus(200);
    }

    //Add a single structure test here so we only ever have to change one test here
    public function test_can_see_json_structure(): void
    {
        $response = $this->get('/api/recipe/search');
        $response->assertJsonStructure([
            'metaData',
            'data' => [
                '*'=>[
                    'RecipeID',
                    'Name',
                    'Description',
                    'Ingredients',
                    'Steps',
                    'AuthorEmail',
                    'Slug'
                ]
            ]
        ]);
    }

    public function test_can_search_random_input(): void
    {
        $response = $this->get('/api/recipe/search?' . rand());
        $response->assertStatus(200);
    }

    public function test_search_out_of_bounds_page(): void
    {//no defined use case for how api errors should be handled. Should just match a standard, but this is a code test
        $response = $this->get('/api/recipe/search?page=1000000');
        $response->assertStatus(404);
    }

    public function test_search_invalid_email(): void
    {
        $response = $this->get('/api/recipe/search?email=test');
        $response->assertStatus(422);
    }
    public function test_search_valid_email(): void
    {
        $response = $this->get('/api/recipe/search?email=test@test.com');
        $response->assertStatus(200);
    }

    public function test_search_invalid_page_value(): void
    {
        $response = $this->get('/api/recipe/search?page=page');
        $response->assertStatus(422);
    }

    public function test_search_empty_page_value(): void
    {
        $response = $this->get('/api/recipe/search?page=');
        $response->assertStatus(422);
    }
/*
//we are overriding the limit on the server so we don't have issues with data sizing
/api/recipe/search?limit=10000
 */
    //This is a business rule baseline I added to the validator, otherwise we would be testing framework code...
    public function test_search_max_length_values(): void
    {
        $response = $this->get('/api/recipe/search?keyword=testttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestt');
        $response->assertStatus(422);

        $response1 = $this->get('/api/recipe/search?ingredient=testttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestttestt');
        $response->assertStatus(422);
    }

    public function test_search_honeypot(): void
    {
        $response = $this->get('/api/recipe/search?password=teest');
        $response->assertStatus(403);
    }


    public function test_search_limit_add(): void
    {
        $response = $this->get('/api/recipe/search?limit=10000');
        $response->assertStatus(200);
    }


    /*
now that we are through the basic validation cases, we can do a basic service test
     */




}
