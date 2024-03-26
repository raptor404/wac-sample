<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Http\Requests\RecipeSearchRequest;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\RecipeStep;
use App\Services\RecipeSearchService;
use Illuminate\Http\Request;

class RecipeSearchController extends Controller
{
    public function index(Request $request, Recipe $recipe)
    {
        $data = [];
        $limit = 10;
        $page = $request->input('page', 1);
        $offset = ($page -1) * $limit;

        $records = Recipe::count();
        $metaData = [
            'page' => $page,
            'pageSize' => $limit,
            'recordCount'=> $records,
            'pages'=> round($records/$limit)
        ];

        $recipeResult =  $recipe
            ->with(
                'ingredients:RecipeID,Text',
                'steps:RecipeID,Text,Order',
                'author:AuthorID,EmailAddress'
            )
            ->limit(10)
            ->offset($offset)
            ->get();

        //Add try catch here
        $data = $recipe->formatter(
            $recipeResult
        );

        return Helpers::jsonApiResponse('recipes', $data, $metaData, 200);
    }

    public function search(RecipeSearchRequest $request, RecipeSearchService $recipeSearchService )
    {
        $data = [];
        $limit = 10;
        $page = $request->input('page', 1);

        $metaData = [
            'page' => $page,
            'pageSize' => $limit,
        ];

        //Add try catch here
        $data = $recipeSearchService->search($request);
        $metaData['recordCount'] = $recipeSearchService->lastResultCount;
        $metaData['pages'] = round($recipeSearchService->lastResultCount/$limit);

        return Helpers::jsonApiResponse('recipes', $data, $metaData, 200);
    }
}
