<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeStep extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'RecipeStep';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'RecipeStepID';


    protected $fillable = [
        'RecipeID',
        'Text',
        'Order',
    ];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class,'Recipe', 'RecipeID','RecipeID');
    }

}
