<?php

namespace ShellaiDev\Models\Parent;

use ShellaiDev\Interfaces\Models\IParams;

class Model implements IParams {

    protected $params;

    public function getParams(){
        return $this->params;
    }

    public function setParams($params){
        $this->params = $params;
    }

    public function appendParams($key, $params){
        $this->params[$key] = $params;
    }

}

?>