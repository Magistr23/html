<?php

namespace ShellaiDev\Models\System;

use Output;

class Router{

    private $routes;
    private $controller;
    private $method;
    private $request;
    private $template;
    private $requestType = null;

    public function __construct($routes){
        $this->routes = $routes;
        $this->request = $_REQUEST;
    }

    public function dispatch(){
        $routeExists = $this->parseRoute();
        ServiceProvider::registerService('request', $this->request);
        if( $_FILES != null && count($_FILES) > 0) ServiceProvider::registerService('files', $_FILES);

        if($routeExists){
            $this->execute();
        } else {
            // If route doesn't exist
            if( Request::isAjax() ) {
                Output::printJsonAnswer('error', "[404] Can't find route!");
            } else {
                die("[404] Can't find route!");
            }
        }
    }

    private function parseRoute(){
        $this->template = $this->parseTemplate();
        $searchedRoute = $this->template['pattern'] ?? $this->template;

        if( array_key_exists($searchedRoute, $this->routes) ){
            $this->setRouteParams();
            $params = explode('@', $this->routes[$searchedRoute][0]);

            $this->controller = $params[0];
            $this->method = $params[1];

            /* Set a request type (GET/POST/REQUEST) */
            $this->setRequestType($searchedRoute);
            /* Set additional params*/
            $this->setAdditionalParams($searchedRoute);

            return true;
        }

        return false;
    }

    private function execute(){
        $controller = new $this->controller();
        if( method_exists($controller, $this->method) ){
            $this->checkRequestMethod($this->requestType);
            call_user_func( array($controller, $this->method) );
        } else {
            if( Request::isAjax() ) {
                Output::printJsonAnswer('error', "[404] Can't find calling method!");
            } else {
                die("[404] Can't find calling method!");
            }
        }
    }

    private function setRouteParams(){
        $routeParts = explode('/', $this->template['pattern'] ?? $this->template);
        $size = count($routeParts);

        $this->request['act'] = $routeParts[0];
        $this->request['mod'] = $size > 1 ? $routeParts[1] : $this->request['act'];

        if( isset($this->template['variables']) ){
            $this->request['params'] = $this->template['variables'];
        }
    }

    private function parseTemplate(){
        $requestParts = explode("/", $this->request['route']);

        $regex = "/$requestParts[0]\/(.*)/";
        $routes = preg_grep($regex, array_keys($this->routes));

        foreach($routes as $route){
            preg_match_all('/{([^}]+)}/', $route, $matches);
            $prepared_pattern = preg_replace('/\//', '\\/', $route);
            if (!empty($matches) && !empty($matches[0])) {
                $variable_names = $matches[1];
            
                // Replace variables with match groups
                $prepared_pattern = preg_replace('/{([^}]+)}/', '([^\/]*)', $prepared_pattern);

                // Match as default string at the end of url ('$' modifier)
                preg_match_all('/' . $prepared_pattern . '$/', $this->request['route'], $matched_url);

                if (!empty($matched_url) && !empty($matched_url[0])) {
                    $variables = array();
                    foreach($variable_names as $idx => $name) {
                        $variables[$name] = $matched_url[$idx + 1][0];
                    }
     
                    return ["pattern" => $route, "variables" => $variables];
                }
            } else {
                // Match as default string at the end of url ('$' modifier)
                preg_match('/' . $prepared_pattern . '$/', $this->request['route'], $matched_url);
    
                if (!empty($matched)) {
                    // We matched a pattern here like /a/b
                    return ["pattern" => $route, "variables" => []];
                }
            }
        }

        return $this->request['route'];
    }

    private function setRequestType($route){
        if( isset($this->routes[$route][1]) && !empty($this->routes[$route][1]) ){
            if( isset($this->routes[$route][1]['method']) ) $this->requestType = $this->routes[$route][1]['method'];
        }
    }

    private function setAdditionalParams($route){
        if( isset($this->routes[$route][2]) && !empty($this->routes[$route][2]) ){
            $this->request['custom_params'] = $this->routes[$route][2];
        }
    }

    private function checkRequestMethod($neededRequestType){
        if($this->requestType == null) die("Undefined request type!");

        if( $neededRequestType === strtoupper('REQUEST') ) return;

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($_SERVER['REQUEST_METHOD'] !== strtoupper($neededRequestType) ) {
            die("[BAD REQUEST METHOD] '{$requestMethod}' request method is not available for this action!");
        }
    }
}

?>