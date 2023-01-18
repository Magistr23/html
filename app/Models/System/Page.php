<?php

namespace ShellaiDev\Models\System;

class Page extends File {

    /** Render child page based on parent */
    public static function render($childTemplate, $parentTemplate, $params){
        if( !file_exists($childTemplate) ) return false;

        $paramsToInclude = [
            'childFile' => $childTemplate
        ];
        $paramsToInclude = array_merge($paramsToInclude, $params);
        self::includeFileWith($parentTemplate, $paramsToInclude);
    }

    /* Redirect to page with messages */
    public static function redirectWithMessage($route, $status = false, $message = false){
        if($message) $_SESSION['message'] = $message;
        if($status) $_SESSION['status'] = $status;

        self::redirect($route);
    }

    /* Redirect to page */
    public static function redirect($route){
        header("Location: " .BASE_URL. "/{$route}");
        exit();
    }
}

?>