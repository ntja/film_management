<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Repositories\Util\LogRepository as LogRepo;

class FilmController extends Controller
{    
    
	public function get(Request $request, $id) {        
        return view('film.item')->with(['film' => $id]);
    }
}
