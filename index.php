<?php
/* Main app point */

require_once 'init.php';

if( isset($_REQUEST['route']) ){
    $routes = require_once 'routes.php';
    $router = new ShellaiDev\Models\System\Router($routes);
    $router->dispatch();
} else {
    die('No route was set!');
}

?>