<?php

namespace ShellaiDev\Models;

use ShellaiDev\Config;
use ShellaiDev\Models\System\Base;
use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;

class Monitoring {

    public function checkMon(){
        $info = [];
        try {
            $query = new MinecraftPing(Config::MONITORING['ip'], Config::MONITORING['port'], 1);
            $info = $query->Query();
        } catch( MinecraftPingException $e ) {
            return 'OFFLINE';
        } finally {
            if( isset($query) ) $query->Close();
        }

        return $info['players']['online'] ?? 'OFFLINE';   
    }

}

?>