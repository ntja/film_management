<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table = 'comments';
    public $timestamps = false;
    protected $fillable = [
        'content', 'post_date', 'user', 'film'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
	// 1 to * relationship with results table
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
	/*
	// 1 to * relationship with results table
    public function film(){
        return $this->belongsTo('App\Models\Film');
    }
	*/
}
