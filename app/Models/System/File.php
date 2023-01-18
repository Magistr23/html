<?php

namespace ShellaiDev\Models\System;

class File {

    /** Include file */
    public static function include($file){
        if( !file_exists($file) ) throw new \Exception("Can't find file: " .$file );

        $params = self::checkFlashMessages();
        if( !empty($params) ) extract($params);
        include_once $file;
        self::unsetFlashMessages();
    }

    /** Include file with params */
    public static function includeFileWith($file, $params){
        if( !file_exists($file) ) throw new \Exception("Can't find file: " .$file );

        $flashMessages = self::checkFlashMessages();
        $compiledParams = array_merge($params, $flashMessages);
        extract($compiledParams);
        include_once $file;
        self::unsetFlashMessages();
    }

    /** Check flash messages params */
    private static function checkFlashMessages(){
        $params = [];
        if( self::areFleshMessagesPresent() ){
            $params['status'] = $_SESSION['status'];
            $params['message'] = $_SESSION['message'];
        }

        return $params;
    }

    /** Are flesh messages present?  */
    public static function areFleshMessagesPresent(){
        return isset($_SESSION['status']) && isset($_SESSION['message']);
    }

    /** Clear flash messages */
    private static function unsetFlashMessages(){
        if( isset($_SESSION['status']) ) unset($_SESSION['status']);
        if( isset($_SESSION['message']) ) unset($_SESSION['message']); 
    }

    /** Load file to variable  */
    public static function loadToVar($file, $params = []){
        if( !file_exists($file) ) return false;

        ob_start();
        
        if( !empty($params) ) extract($params);
        include_once $file;

        return ob_get_clean();
    }

    /* Read JSON-file */
    public static function readJsonFile($file){
        $fileContent = file_get_contents($file);
        return json_decode($fileContent, true);
    }

    /* Write to file */
    public static function writeFile($file, $data){
        file_put_contents($file, $data);
    }
}

?>