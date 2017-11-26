<?php

namespace App\Repositories\Util;

//use App\Models\Accounts;
//use App\Repositories\Custom\Resource\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class AclPolicy {

    use HandlesAuthorization;
    
    const RESOURCE_USER = "App\Repositories\Resource\User";	
	
	/*
     * Create a new policy instance.
     *
     * @return void
     */

    public function __construct() {
        //
    }

    public function post($user, $resource, $owner = false) {
        if (is_object($resource)) {
            if (!strcasecmp(get_class($resource), self::RESOURCE_USER)) {
				//var_dump($user->getRole());die();
                $role = ["GUEST"];
                if (in_array($user->getRole(), $role)) {                    
                    return true;                        
                } else {
                    return false;
                }
			} 
		}
	}

	public function get($user, $resource, $owner = false) {		
	}
}
