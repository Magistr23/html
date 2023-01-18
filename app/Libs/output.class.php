<?php

class Output {

    /**
     * Вывод JSON с поддержкой кириллицы
     * @param [String] $msg
     * @return JSON
     */
    public static function toJsonMsg($msg){
        return json_encode($msg, JSON_UNESCAPED_UNICODE);
    }

    /** Добавление заголовков для вывода JSON-сообщений */
    public static function addJsonHeaders(){
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json; charset=utf-8;");
    }

    /** Генерация ответа */
    public static function genAnswer($status, $message){
        return ['status' => $status, 'answer' => $message];
    }

    /** Вывод JSON-сообщения */
    public static function printJsonAnswer($status, $message){
        self::addJsonHeaders();
        $answer = self::genAnswer($status, $message);
        echo self::toJsonMsg($answer);
        exit();
    }

    /** Вывод JSON-объекта */
    public static function printJsonObject($object){
        self::addJsonHeaders();
        echo self::toJsonMsg($object);
        exit();
    }
}

?>