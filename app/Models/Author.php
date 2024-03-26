<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Author';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'AuthorID';


    protected $fillable = [
      'EmailAddress',
    ];

    public function recipe(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class,'Recipe', 'AuthorID','AuthorID');
    }

}
