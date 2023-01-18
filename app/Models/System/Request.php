<?php

namespace ShellaiDev\Models\System;

use Output;

class Request {

    /** Is request AJAX? */
    public static function isAjax(){
        if( !isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) return false;
        return strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /** Check CSRF Token */
    public static function checkCSRF(){
        $request = ServiceProvider::getService('request');
        if( !Security::checkCsrfToken($request) ){
            self::processAnswer('error', 'Не соответствует токен. Обновите страницу и повторите попытку!');
        }
    }

    /** Check if all request input values are present */
    public static function checkNeededInputs($inputs){
        $request = ServiceProvider::getService('request');
        foreach($inputs as $item){
            if( !isset($request[$item]) ) {
                self::processAnswer('error', 'Не все поля заполнены. Повторите попытку!');
            }
        }
    }

    /** Check request inputs length
     * Format: [ key => [min_length, max_length] ]
     * Set max_length = -1 to reset max_length limits
     */
    public static function checkInputsLength($inputs){
        $request = ServiceProvider::getService('request');

        $answer = [];
        $badLength = false;

        foreach($inputs as $key => $value){
            $length = strlen($request[$key]);
            if($length < $value[0]) {
                $answer['status'] = 'error';
                $answer['message'] = "Минимальная длина поля `{$key}`: {$value[0]} символов!";
                $badLength = true;
                break;
            } else if($value[1] != -1 && $length > $value[1]){
                $answer['status'] = 'error';
                $answer['message'] = "Максимальная длина поля `{$key}`: {$value[1]} символов!";
                $badLength = true;
                break;
            }
        }

        if(!$badLength) return;

        self::processAnswer($answer['status'], $answer['message']);
    }

    /** Check if input contains cyrillic */
    public static function containsCyrillic($input) {
        return preg_match('/[А-Яа-яЁё]/u', $input);
    }

    /* Process answer by request */
    public static function processAnswer($status, $message){
        if( self::isAjax() ) {
            Output::printJsonAnswer($status, $message);
        } else {
            Page::redirectWithMessage('', $status, $message);
        }
    }
}

?>