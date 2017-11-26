<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Util\LogRepository as LogRepo;
use Validator;
use JWTAuth;

class AuthController extends Controller
{   
	public function post(Request $request){
		try {
			//retrieve data sent to the API - JSON format
			$user_info = file_get_contents('php://input');
			//var_dump($user_info);die();
			$data = json_decode($user_info, TRUE);
			if (!is_array($data)) {
				$result = array("code" => 400, "description" => "invalid request body");
				return response()->json($result, 400);
			}
			//validation of data
			$validator = Validator::make($request->all(), [
				'email' => 'required|email',
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
			
			$row = User::where('email', 'LIKE BINARY', $data['email'])->first();
			if($row){
				$information = array(
					'email' => $data['email'],
					'password' => $data['password'],
				);
				if (!$token = JWTAuth::attempt($information)) {
					$result = "Authentication failed. Invalid email address or password";
					return response()->json(["code" =>422, "description" => $result], 422);
				}
				$result = $this->prepareResponseAfterPost($row,$token);				
				return response()->json($result, 200);				
			}else{
				$result = "Authentication failed. Invalid email address or password";				
				return response()->json(["code" =>422, "description" => $result], 422);
			}			
		} catch (Exception $ex) {
            LogRepo::printLog('error', $ex->getMessage() . " in " . $ex->getFile() . " at line " . $ex->getLine());
			return response()->json(["code" =>500, "description" => "An internal server error occured"], 500);
        }	
    }
	
	public function prepareResponseAfterPost($row, $token) {
        try {         
            $result = array(
                'code' => 200,
                'id' => $row->id,
				'full_name' => $row->full_name,
				'email' => $row->email,
				'token' => $token,
				'ttl' => config('jwt.ttl'),
                );
            return $result;
        } catch (Exception $ex) {
            LogRepo::printLog('error', $ex->getMessage() . " in " . $ex->getFile() . " at line " . $ex->getLine());
			return response()->json(["code" =>500, "description" => "An internal server error occured"], 500);
        }
    }
}
