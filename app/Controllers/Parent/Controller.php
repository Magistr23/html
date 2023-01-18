<?php

namespace ShellaiDev\Controllers\Parent;

use ShellaiDev\Models\System\Security;
use ShellaiDev\Models\System\ServiceProvider;

class Controller {

    protected $request;   // Incoming request
    protected $data = [];    // Data to inject

    public function __construct(){
        $this->request = Security::cleanRequest( ServiceProvider::getService('request') );
    }

    protected function fillData($data){
        foreach($data as $key => $value){
            $this->data[$key] = $value;
        }
    }

}

?>