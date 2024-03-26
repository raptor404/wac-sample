<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/* empty search and just get first X results */
Route::get('/recipe', [\App\Http\Controllers\RecipeSearchController::class, 'index']);

/** Consider this syntax to cut down validation in controller */
/*
Route::get('/recipe/search/{type}/{param1}', [\App\Http\Controllers\RecipeSearchController::class, 'searchSingle'])
    ->where('type','(keyword|email|ingredient)')
    ->where('param1', '[A-Za-z0-9]+');
*/

//this is def the cleanest route syntax, but all validation is dumped to the controller?
//if we swap this to a post  we can use form request handler?
Route::get('/recipe/search', [\App\Http\Controllers\RecipeSearchController::class, 'search']);
