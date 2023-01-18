<?php

namespace ShellaiDev\Controllers;

use Output;
use ShellaiDev\Controllers\Parent\Controller;
use ShellaiDev\Models\Monitoring;

class MonitoringController extends Controller {

    private Monitoring $monitoring;

    public function __construct(){
        parent::__construct();
        $this->monitoring = new Monitoring();
    }

    public function check(){
        $ping = $this->monitoring->checkMon();
        Output::printJsonAnswer('success', $ping);
    }

}

?>