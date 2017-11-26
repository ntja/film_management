<?php

namespace App\Http\Controllers\Films\Film;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Repositories\Util\LogRepository as LogRepo;
use Validator;
use DB;

class CommentsController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth', ['except' => ['get']]);
    }
    
	public function post(Request $request, $id){
		try {
			//retrieve data sent to the API - JSON format
			//var_dump($request->input());die();
			$film_info = file_get_contents('php://input');
			$data = json_decode($film_info, TRUE);
			if (!is_array($data)) {
				$result = array("code" => 400, "description" => "invalid request body");
				return response()->json($result, 400);
			}
			//validation of data
			$validator = Validator::make(array_merge($request->all(), ['id' => $id]), [				
				'content'          => 'required|string',
				'id'          => 'required|exists:films,id',
				'user'          => 'required|exists:users,id',
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
				'content' => $data["content"],				
				'film' =>  $id,
				'user' => $data["user"],
			);			
			//var_dump($information);die();
			//save user information in DB			
			$row = Comment::create($information);			
			$result = $this->prepareResponseAfterPost($row->id);
			LogRepo::printLog('info', "The new comment #".$row->id." has just been made. Request inputs:  #{" . var_export($information,true) . "}.");
			return response()->json($result, 201);
		} catch (Exception $ex) {
			DB::rollback();
            LogRepo::printLog('error', $ex->getMessage() . " in " . $ex->getFile() . " at line " . $ex->getLine());
			return response()->json(["code" => 500, "description" => "An internal server error occured"], 500);
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
			return response()->json(["code" => 500, "description" => "An internal server error occured"], 500);
        }
    }
}
