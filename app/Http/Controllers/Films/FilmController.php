<?php

namespace App\Http\Controllers\Films;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Repositories\Util\LogRepository as LogRepo;

class FilmController extends Controller
{    
    
	public function get(Request $request, $id){
		try{
			//retrieve a film
			if(is_numeric($id)){
				$film = Film::with(
					[
						'comments'=> function ($query) {
							$query->join('users','users.id', '=', 'comments.user')->select('film','content','post_date','users.full_name');
						},
						'genres'
					]
				)
				->where("id",$id)
				->select('films.*')
				->first();
			}else{
				$film = Film::with(
					[
						'comments'=> function ($query) {
							$query->join('users','users.id', '=', 'comments.user')->select('film','content','post_date','users.full_name');
						},
						'genres'
					]
				)
				->where("slug_name", "LIKE", $id)
				->select('films.*')
				->first();
			}	
			return [
				"code" => 200, 
				"data" => $film?$film:[],
			];
		}catch(Exception $ex){
			LogRepo::printLog('error', $ex->getMessage() . " in " . $ex->getFile() . " at line " . $ex->getLine());
			return response()->json(["code" =>500, "description" => "An internal server error occured"], 500);
		}		        
    }		
}
