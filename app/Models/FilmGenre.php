<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class FilmGenre extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table = 'film_genres';
    public $timestamps = false;
    protected $fillable = [
        'film', 'genre'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];	
}
