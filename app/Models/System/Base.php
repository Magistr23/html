<?php

namespace ShellaiDev\Models\System;

use ShellaiDev\Config;

class Base {

    /* Auto-generate Base Url */
    public static function baseUrl(){
        $httpHost = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' || Config::HAS_SSL ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        return empty( Config::SITE_DIR ) ? "{$httpHost}" : "{$httpHost}/".Config::SITE_DIR;
    }

    /** Pretty printed variables */
    public static function prettyPrint($value){
        print("<pre>".print_r($value,true)."</pre>");
    }

    /* Randomizer */
    public static function getRandom($min, $max, $step){
        $temp = range($min, $max, $step);
        return $temp[ mt_rand(0, count($temp)-1) ];
    }

    /* Remove trailing zero's */
    public static function removeTrailingZeros($number){
       return rtrim(sprintf('%.40F', $number), '0');
    }

    /* Float with digits */
    public static function parseFloat($number, $digits){
       return sprintf("%.{$digits}F", $number);
    }
}

?>