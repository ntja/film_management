<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

class GetUserFromToken extends BaseMiddleware
{
    
    const SESSION_TOKEN = 'token';    

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next, $force_success = 0)
    {        
        $token = $request->session()->get(self::SESSION_TOKEN);
		//var_dump($token);die();
        //$request_client_id = $request->header(self::CLIENT_ID);
        
        if (! $token ) {
            if(!$force_success){
                $result = array("code" => 4000, "description" => "token not provided");
               echo json_encode($result, JSON_UNESCAPED_SLASHES);
               die();   
            }
            $request->request->add(['user_id' => null]);
            $request->request->add(['token' => null]);
			$request->request->add(['user_role' => null]);
            return $next($request);
        }
        
        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
			$result = array("code" => 4003 , "description" => "token expired");
            echo json_encode($result, JSON_UNESCAPED_SLASHES);
            die();
        } catch (JWTException $e) {
           $result = array("code" => 4000, "description" => "token invalid");
            echo json_encode($result, JSON_UNESCAPED_SLASHES);
            die();
        }

        if (! $user) {
            return $this->respond('tymon.jwt.user_not_found', 'user not found', 404);
        }
        $request->request->add(['user_id' => $user->id]);
		$request->request->add(['user_role' => $user->role]);
        $request->request->add(['token' => $token]);
        
        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }
}
