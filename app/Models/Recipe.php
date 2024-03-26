<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Recipe extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Recipe';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'RecipeID';


    protected $fillable = [
        'Name',
        'Description',
        'AuthorID',
        'Slug'
    ];

    public function ingredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class, 'RecipeID', 'RecipeID');
    }

    public function steps(): HasMany
    {
        return $this->hasMany(RecipeStep::class, 'RecipeID', 'RecipeID')->orderBy('Order','ASC');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'AuthorID', 'AuthorID');
    }

    public function formatter(Collection $collection)
    {
        return $collection->map(function($recipe){
            $steps = $recipe->steps->map(function($recipeStep){
               return [
                   'Order'=>$recipeStep->Order,
                   'Text'=> $recipeStep->Text,
               ];
            })->toArray();

            $ingredients = $recipe->steps->map(function($recipeIngredient){
                return [
                    'Text'=>  $recipeIngredient->Text,
                ];
            })->toArray();

            return [
                'RecipeID' =>$recipe->RecipeID,
                'Name'=> $recipe->Name,
                'Description' => $recipe->Description,
                'AuthorEmailAddress'=> $recipe->author->EmailAddress,
                'Slug'=> $recipe->Slug,
                'Steps'=>$steps,
                'Ingredients'=> $ingredients,
            ];
        })->toArray();

    }

}
