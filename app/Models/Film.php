<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table = 'films';
    public $timestamps = false;
    protected $fillable = [
        'name', 'slug_name', 'description', 'release_date', 'rating', 'country', 'ticket_price', 'photo',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
	
	// Comments thqt belong to film
    public function comments(){
        return $this->hasMany('App\Models\Comment', 'film');
    }
	
	// genres that belong to film
	public function genres()
    {
        return $this->belongsToMany('App\Models\Genre', 'film_genres', 'film', 'genre');
    }
}
