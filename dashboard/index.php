<?php

define('__VALID_ENTRANCE', 1);

include('../config/Autoload.php');

ob_start();

$halaman = @$_GET['param'];
$halamanpath = explode('/', $halaman);

// Variabel
$page = $halamanpath[0];
$id = $halamanpath[2];
$p_act = $halamanpath[1];

if(empty($page)) {
  $page = "index";
}

// // Cek Authentikasi Dulu
if(!Auth::isLogin()) {
  Route::redirect('../auth/login');
}

// Ambil Halaman
$pagedir = Route::getViewPath($page);
if(is_readable($pagedir)) {
  require_once($pagedir);
} else if(!is_readable($pagedir)) {
  $pagedir = Route::getViewPath("404");
  require_once($pagedir);
}
