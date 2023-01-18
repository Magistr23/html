<?php

namespace ShellaiDev\Models\System;

class Security {

    // Clean input to filter bad values
    public static function cleanInput($input){
        $input = preg_replace("/[^a-zA-Zа-яА-Я0-9-_!@:.,\/\s]/i", "", $input);
        $input = strip_tags($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    // Filter request-array for bad input
    public static function cleanRequest($array, $excluded = []){
        foreach($array as $key => $value){
            if( in_array($key, $excluded) ) continue;

            if( is_array($value) ) {
                self::cleanRequest($value);
            } else {
                $array[$key] = self::cleanInput($value);
            }
        }

        return $array;
    }

    /** Generate token to protect users from CSRF attack */
    public static function generateCsrfToken(){
        if( !isset($_SESSION['csrf_token']) || empty($_SESSION['csrf_token']) ) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    /** Returns generated CSRF-token*/
    public static function getCsrfToken(){
        return $_SESSION['csrf_token'] ?? null;
    }

    /** Check client's CSRF-token */
    public static function checkCsrfToken($request){
        if( !isset($request['csrf_token']) ) return false;

        $csrfToken = self::getCsrfToken();
        if( $csrfToken == null) return false;

        return hash_equals($csrfToken, $request['csrf_token']);
    }

    /** Return only needed keys from array */
    public static function whitelistedKeys($array, $keys){
        return array_filter($array, 
            function ($key) use ($keys) {
                return in_array($key, $keys);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}

?>