<?php

namespace App\Services;

use App\Exceptions\RecipeSearchException;
use App\Http\Requests\RecipeSearchRequest;
use App\Models\Recipe;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RecipeSearchService
{

    public Recipe $recipe;
    public int $lastResultCount = 0;

    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;

    }

    /**
     * @param RecipeSearchRequest $request
     * @return array
     * @throws RecipeSearchException
     */
    public function search(RecipeSearchRequest $request): array
    {
        //gather input
        $author = $request->input('author', null);
        $ingredient = $request->input('ingredient', null);
        $keyword = $request->input('keyword', null);

        $page = $request->input('page', 1);
        $limit = 10;

        $offset = ($page - 1) * $limit;

        //get result sets
        $authorResult = $this->getAuthorResults($author);
        $ingredientResult = $this->getIngredientResults($ingredient, $keyword);
        $keywordResult = $this->getKeywordResults($keyword);

        $idIntersect = $this->array_intersections($authorResult, $ingredientResult, $keywordResult);

        $this->lastResultCount = count($idIntersect);
        if ($offset > $this->lastResultCount) {
            $this->newSearchException('Page out of bounds');
        }

        //fetch the data then format it
        return $this->recipe->formatter(
            $this->recipe
                ->with('ingredients', 'steps', 'author')
                ->whereIn('Recipe.RecipeID', $idIntersect)
                ->limit(10)
                ->offset($offset)
                ->get()
        );
    }

    public function array_intersections(array &$authorResult, array &$ingredientResult, array &$keywordResult): array
    {
        $filtered = array_filter([$authorResult, $ingredientResult, $keywordResult]);

        if(count($filtered)===0){
            return [];
        }

        usort($filtered, function ($a, $b) {
            return count($a) - count($b);
        });

        return array_intersect(...$filtered);
    }

    public function getAuthorResults(?string $author): array
    {
        if ($author === null) {
            return [];
        }

        return DB::table('Recipe')
            ->join('Author', 'Recipe.AuthorID', '=', 'Author.AuthorID')
            ->select('RecipeID')
            ->where('EmailAddress', '=', $author)
            ->groupBy('RecipeID')
            ->get()
            ->pluck('RecipeID')
            ->toArray();

    }

    public function getIngredientResults(?string $ingredient, ?string $keyword): array
    {

        if ($ingredient === null) {
            return [];
        }

        $ingredientQuery = DB::table('RecipeIngredient')
            ->select('RecipeID')
            ->where('Text', 'like', '%' . $ingredient . '%')
            ->groupBy('RecipeID');


        return $ingredientQuery->get()
            ->pluck('RecipeID')
            ->toArray();
    }

    public function getKeywordResults(?string $keyword): array
    {
        if ($keyword === null) {
            return [];
        }

        return DB::table('Recipe')
            ->select('Recipe.RecipeID')
            ->join('RecipeStep', 'RecipeStep.RecipeID', '=', 'Recipe.RecipeID')
            ->join('RecipeIngredient', 'RecipeIngredient.RecipeID', '=', 'Recipe.RecipeID')
            ->where('Recipe.Name', 'like', '%' . $keyword . '%')
            ->orWhere('Recipe.Description', 'like', '%' . $keyword . '%')
            ->orWhere('RecipeStep.Text', 'like', '%' . $keyword . '%')
            ->orWhere('RecipeIngredient.Text', 'like', '%' . $keyword . '%')
            ->groupBy('RecipeID')
            ->get()
            ->pluck('RecipeID')
            ->toArray();

    }

    /**
     * @param string $message
     * @return void
     * @throws RecipeSearchException
     */
    public function newSearchException(string $message): void
    {
        //TODO get a list of reportable exceptions to help the dev using the api, and a list of suppress exceptions for opsec
        throw new RecipeSearchException($message);
    }
    /*
     * one option for expansion would be to do a search separate from the data build out of the object themselves
     * essentially we would build the recipe record separately cache it by id (like we might in nosql)
     * Then query the db based on input provided, NAND the results, then call get for each record we want
     * Looks like you can call mget in redis to grab a result set
     *
    public function getCachedRecipe(int $id){

    }
    public static function cacheRecipeByID(){

    }*/
}
