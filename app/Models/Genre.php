<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Genre extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table = 'genres';
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];	
}
