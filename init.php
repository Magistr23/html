<?php

use ShellaiDev\Config;

define('SHELLAIDEV_AUTODONATE_2022', true);

require 'vendor/autoload.php';

session_start();

date_default_timezone_set("Europe/Moscow");

/* Debug mode (if enabled in config) */
if(Config::DEBUG_ENABLED){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/* Parse servers, categories and items */
Config::parseConfigs();

/* Global variables */
define('APP_DIR', __DIR__);
define('TPL_DIR', APP_DIR.'/template');
define('BASE_URL', ShellaiDev\Models\System\Base::baseUrl() );
define('TPL_URL', BASE_URL.'/template');
define('ASSETS_URL', TPL_URL.'/assets');

/* Generate CSRF-TOKEN (Protection against CSRF) */
ShellaiDev\Models\System\Security::generateCsrfToken();

/* Init database connection */
ShellaiDev\Models\System\DB::init();

?>