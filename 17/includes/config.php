<?php

require_once("application.php");

define('BD_HOST', 'localhost');
define('BD_NAME', 'aw_c');
define('BD_USER', 'aw_c');
define('BD_PASS', 'aw_c');

ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

$app = application::getInstance();

$app->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS));

register_shutdown_function([$app, 'shutdown']);

?>