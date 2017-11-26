<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Gate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Util\LogRepository as LogRepo;
use App\Repositories\Resource\User as ResourceUser;
use Validator;
use JWTAuth;

class UsersController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth', ['except' => ['login','register','getUsers','logout']]);
    }
    
    /**
     * login user
     * @param  array
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try{
			//var_dump(get_class_methods($request));die();			
			//get user input			
            $user_info = $request->input();			
			//validation of user input
			$validator = Validator::make($user_info,[
				'username' => 'required',
				'password' => 'required',
			])->validate();
			
			$username_email = $user_info["username"];
			$password = $user_info["password"];
			if($this->isEmail($username_email)){
				//die("here1");
				$row = User::where('email', 'LIKE BINARY', $username_email)->first();
				if($row){
					$information = array(
						'email' => $username_email,
						'password' => $password,
					);
					if (!$token = JWTAuth::attempt($information)) {
						\Session::flash('error',"Authentication failed. Invalid email address or password");
						return \Redirect::back();
					}
					$request->session()->put('token',$token);
					$request->session()->flash('success',"Successful authentication !");
					return \Redirect::to('users');
				}else{
					\Session::flash('error',"Authentication failed. Invalid email address or password");
					return \Redirect::back();
				}
			}else{
				//die("here2");
				$row = User::where('first_name', $username_email)->where('passcode', $password)->first();
				//var_dump($row);die();
				if($row){
					if (!$token = JWTAuth::fromUser($row)) {
						\Session::flash('error',"Authentication failed. Invalid name or passcode");
						return \Redirect::back();						
					}
					$request->session()->put('token',$token);
					$request->session()->flash('success',"Successful authentication !");
					return \Redirect::to('users');
				}else{
					\Session::flash('error',"Authentication failed. Invalid name or passcode");
					return \Redirect::back();
				}
			}			
        } catch (Exception $ex) {
            LogRepo::printLog('error', $ex->getMessage() . " in ". $ex->getFile(). " at line ". $ex->getLine());
			die();
        } 
        
    }

    /**
     * Registering user
     *
     * @param  array
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){
        try{			
			//get user input
            $user_info = $request->input();
			//var_dump($user_info);die();
			//validation of user input
			$validator = Validator::make($user_info,[
				'first_name' => 'required',
				'last_name' => 'required',
				'email' => 'required|email|unique:users',
				'password' => 'required',
				'confirm-password' => 'required|same:password',
			])->validate();
			
			//preapring data to be saved			
			
			$information = array(
				'email' => $user_info["email"],
				'first_name' =>  $user_info["first_name"],
				'last_name' =>  $user_info["last_name"],
				'role' =>  $user_info["role"],
				'password' => Hash::make($user_info["password"]),				
			);
			//save user information in DB
			$row = User::create($information);
			
			if($row){
				// if everything is ok
				$request->session()->flash('success',"<b>{$row->name} </b>your account has been successfully created. You can login now.");
				return \Redirect::to('login');
				//return \Redirect::to('/login');
			}else{
				// if error occured
				\Session::flash('error',"An error occured and your account has not been created. Please try again later");
				return \Redirect::back();
			}
			//var_dump($row);die();
		} catch (Exception $ex) {
            LogRepo::printLog('error', $ex->getMessage() . " in ". $ex->getFile(). " at line ". $ex->getLine());
			die();
        }         
    }	
		
	public function getUsers(Request $request){
		$input = $request->only('query');
		$result = [];
		$query = $input['query'];
		if($query){
			$test_names = User::where("delete_status", '0')->where('name','LIKE', '%'.$query.'%')->orderBy('id','DESC')->get();
		}else{
			$test_names = User::where("delete_status", '0')->orderBy('id','DESC')->get();
		}
		//var_dump($patients);die();
		$result["items"] = $test_names;
       return $result;
	}
	
	public function logOut(Request $request){
        try{
			$request->session()->flush();
			return \Redirect::to('login');
		} catch (Exception $ex) {
            LogRepo::printLog('error', $ex->getMessage() . " in ". $ex->getFile(). " at line ". $ex->getLine());
        }         
    }
	
	// Email verification.
	public function isEmail($email) {
		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
	}
}
