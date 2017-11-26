<?php

namespace App\Repositories\Resource\Users;

class User {

    public $id;

    public function __construct($id = null) {
        if($id){
        	$this->id = $id;
        }
        return $this;
    }

}
