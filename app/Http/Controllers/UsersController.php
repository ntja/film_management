<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Util\LogRepository as LogRepo;
use Illuminate\Support\Str;
use Validator;
use Hash;

class UsersController extends Controller
{   
	public function post(Request $request){
		try {
			//retrieve data sent to the API - JSON format
			$user_info = file_get_contents('php://input');
			$data = json_decode($user_info, TRUE);
			if (!is_array($data)) {
				$result = array("code" => 400, "description" => "invalid request body");
				return response()->json($result, 400);
			}
			//validation of data
			$validator = Validator::make($request->all(), [
				'full_name' => 'required',
				'email' => 'required|email|unique:users',
				'password' => 'required|min:8',
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
				'email' => $data["email"],
				'full_name' =>  $data["full_name"],
				'password' => Hash::make($data["password"]),	
			);			
			//var_dump($information);die();
			//save user information in DB
			$row = User::create($information);
			$result = $this->prepareResponseAfterPost($row->id);
			LogRepo::printLog('info', "The new user #".$row->id." has just been created. Request inputs:  #{" . var_export($information,true) . "}.");
			return response()->json($result, 201);
		} catch (Exception $ex) {
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
