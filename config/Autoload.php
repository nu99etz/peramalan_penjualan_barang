<?php

include('Config.php');

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);

session_start();

if(empty($config['timezone'])) {
    $timezone = 'Asia/Jakarta';
} else {
    $timezone = $config['timezone'];
}

date_default_timezone_set($timezone);

// Load Semua Helper
require_once($config['helpers'].'Auth.php');
require_once($config['helpers'].'Date.php');
require_once($config['helpers'].'Connection.php');
require_once($config['helpers'].'Query.php');
require_once($config['helpers'].'Page.php');
require_once($config['helpers'].'Route.php');
require_once($config['helpers'].'Maintence.php');


$conn = new Query($config);