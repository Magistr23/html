<?php

namespace ShellaiDev\Models\System;

class ServiceProvider {

    private static $container = [];

    /* Register a single service */
    public static function registerService($key, $object){
        if( !array_key_exists($key, self::$container) ) self::$container[$key] = $object;
    }

    /* Register an array of services */
    public static function registerServices($services){
        foreach($services as $key => $value){
            $object = is_string($value) && class_exists($value) ? new $value() : $value;
            self::registerService($key, $object );
        }
    }

    /** Get specified service */
    public static function getService($service){
        if( array_key_exists($service, self::$container) ) return self::$container[$service];
        return null;
    }

}

?>