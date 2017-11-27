<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Repositories\Util\LogRepository as LogRepo;

class GenresController extends Controller
{    
    
	public function get(Request $request){
		try{
			//retrieve a film
				$genres = Genre::orderBy("name","ASC")
				->select('genres.*')
				->get();
			return [
				"code" => 200, 
				"data" => $genres?$genres:[],
			];
		}catch(Exception $ex){
			LogRepo::printLog('error', $ex->getMessage() . " in " . $ex->getFile() . " at line " . $ex->getLine());
			return response()->json(["code" =>500, "description" => "An internal server error occured"], 500);
		}		        
    }		
}
