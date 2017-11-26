<?php

namespace App\Repositories\Resource;

class User {

    public $id;

    public function __construct($id=null) {
    	if($id){
    		$this->id = $id;
    	}
        return $this;
    }

}
