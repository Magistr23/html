<?php

namespace ShellaiDev\Models\System;

use Exception;
use Output;
use ShellaiDev\Config;

class DB {

    /** Global database connection */
    public static $client;
    
    /** Current database */
    public static $database;

    /** Server's database connection */
    public static $server = [
        'client' => [],
        'database' => [],
        'mysql' => []
    ];

    /** Init connection */
    public static function init(){
        try {
            self::$client = new \MongoDB\Client("mongodb://".Config::MONGODB['user'].":".Config::MONGODB['pass']."@".Config::MONGODB['host'].":".Config::MONGODB['port']."/?authSource=".Config::MONGODB['database']);
            self::$client->listDatabases();   // Check connection (If not connected, it will throw an error)
        } catch (Exception $ex) {
           exit( Output::printJsonAnswer('error', 'Site connection error: ' .$ex->getMessage()) );
        }
        
        self::$database = self::$client->{Config::MONGODB['database']};
    }

    /* Init server's connection */
    public static function initServer($serverId){
        try {
            self::$server['client'] = new \MongoDB\Client("mongodb://".Config::$configs['servers'][$serverId]['db']['user'].":".Config::$configs['servers'][$serverId]['db']['pass']."@".Config::$configs['servers'][$serverId]['db']['host'].":".Config::$configs['servers'][$serverId]['db']['port']."/?authSource=".Config::$configs['servers'][$serverId]['db']['database']);
            self::$server['client']->listDatabases();   // Check connection (If not connected, it will throw an error)
        } catch (Exception $ex){
            Request::processAnswer('error', 'Server connection error: ' .$ex->getMessage() );
        }
        
        self::$server['database'] = self::$server['client']->{Config::$configs['servers'][$serverId]['db']['database']};
    }

    /* Init server's mysql connection */
    public static function initServerMysql($serverId){
        self::$server['mysql'] = new \MysqliDb(
            [
                'host' => Config::$configs['servers'][$serverId]['mysql']['host'],
                'username' => Config::$configs['servers'][$serverId]['mysql']['user'], 
                'password' => Config::$configs['servers'][$serverId]['mysql']['pass'],
                'db'=> Config::$configs['servers'][$serverId]['mysql']['database'],
            ]
        );
        
        self::$server['mysql']->autoReconnect = false;
    }
}

?>