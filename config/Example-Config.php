<?php

$config = array();

// Config URL
$config['base_url'] = "http://localhost";
$config['root'] = '/home/nu99etz/public_html';
$config['path'] = '/rekomender_polymetric';
$config['assets'] = $config['path'] . '/assets/';
$config['helpers'] = '../helpers/';
$config['models'] = '../models/';
$config['upload'] = $config['path'] . '/upload/';
$config['include'] = $config['path'] . '/include/';

// Config DB
$config['db_host'] = "localhost";
$config['db_name'] = "rekom_polymetric";
$config['db_username'] = "root";
$config['db_password'] = "";

// Config Appereance

// Main Sidebar ("primary" = Biru, "success" = Hijau, "danger" = Merah, "warning" = Kuning)
$config['main-color'] = "success";
// Nama Aplikasi
$config['tenants-name'] = "Sistem Peramalan CV. SYANA HQ";