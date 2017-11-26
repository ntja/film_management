<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\FilmGenre;
use App\Repositories\Util\LogRepository as LogRepo;
use Illuminate\Support\Str;
use Validator;
use DB;

class FilmsController extends Controller
{    
	public function get(Request $request){
		try {
			$data = $request->only('limit');
			 if (!$data['limit']) {
				$data['limit'] = 1; //set default value of limit param 
			}
			$limit = $data['limit'];
			
			//retrieve paginated list of films
			$films = Film::with(
				[
					'comments'=> function ($query) {
						$query->select('film','content','post_date');
					},
					'genres'
				]
			)		
			->orderBy('films.id','DESC')
			->select('films.*')
			->paginate($limit);
			
			//append limit param to the link
			$films->appends(["limit" => $limit]);
			return $films;
		} catch (Exception $ex) {
			DB::rollback();
            LogRepo::printLog('error', $ex->getMessage() . " in " . $ex->getFile() . " at line " . $ex->getLine());
			return response()->json(["code" =>500, "description" => "An internal server error occured"], 500);
        }		
    }
	
	public function post(Request $request){
		try {
			//retrieve data sent to the API - JSON format
			//var_dump($request->all());die();
			$film_info = file_get_contents('php://input');
			$data = json_decode($film_info, TRUE);
			if (!is_array($data)) {
				$result = array("code" => 400, "description" => "invalid request body");
				return response()->json($result, 400);
			}
			//validation of data
			$validator = Validator::make($request->all(), [
				'name'             => 'required|string',
				'description'      => 'required|string',
				'release_date'     => 'required|date',
				'ticket_price'     => 'required|numeric',
				'rating'           => 'required|numeric|min:1|max:5',
				'country'          => 'required|string',
				'photo'            => 'required|string',
				'genres'            => 'required|array|exists:genres,id',
				'genres.*'          => 'exists:genres,id',
			]);
			if ($validator->fails()) {
				return response()->json(
					[
						"code" => 422,
						'errors' => $validator->messages(),
					], 
					422
				);
			}
			
			//prepare data to send to the DB
			$information = array(
				'name' => $data["name"],
				'description' =>  $data["description"],
				'release_date' =>  date('Y-m-d', strtotime($data["release_date"])),
				'rating' =>  $data["rating"],
				'country' => $data["country"],
				'photo' =>  $data["photo"],
				'ticket_price' =>  $data["ticket_price"],
				'slug_name' =>  Str::slug($data["name"]),
			);			
			//var_dump($information);die();
			//save user information in DB			
			DB::beginTransaction();
			$row = Film::create($information);
			foreach($data['genres'] as $genre){
				$temp = ['genre' => $genre, 'film' => $row->id];
				$film_genres [] = $temp;
			}
			//var_dump($film_genres);die();
			FilmGenre::insert($film_genres);
			DB::commit();
			$result = $this->prepareResponseAfterPost($row->id);
			LogRepo::printLog('info', "The new film #".$row->id." has just been created. Request inputs:  #{" . var_export($information,true) . "}.");
			return response()->json($result, 201);
		} catch (Exception $ex) {
			DB::rollback();
            LogRepo::printLog('error', $ex->getMessage() . " in " . $ex->getFile() . " at line " . $ex->getLine());
			return response()->json(["code" =>500, "description" => "An internal server error occured"], 500);
        }	
    }
	
	public function prepareResponseAfterPost($id) {
        try {         
            $result = array(
                'code' => 201,
                'id' => $id,                
                );
            return $result;
        } catch (Exception $ex) {
            LogRepo::printLog('error', $ex->getMessage() . " in " . $ex->getFile() . " at line " . $ex->getLine());
			return response()->json(["code" =>500, "description" => "An internal server error occured"], 500);
        }
    }
}
