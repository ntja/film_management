<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class User extends Model{
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table = 'users';
    public $timestamps = false;
    protected $fillable = [
        'full_name', 'email', 'password'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}