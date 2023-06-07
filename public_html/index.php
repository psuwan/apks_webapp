<?php
// start using session
session_start();

const DS = DIRECTORY_SEPARATOR;
$dir_apps = dirname(__DIR__) . DS . 'apps';
$dir_root = dirname(__DIR__);

defined('APPLIcATION_PATH') || define('APPLICATION_PATH', realpath($dir_apps));

require APPLICATION_PATH . DS . 'config' . DS . 'config.php';

$page = get('page', 'home');
$model = $config['PATH2_MODEL'] . $page . '.php';
$view = $config['PATH2_VIEW'] . $page . '.phtml';
$_404 = $config['PATH2_VIEW'] . '404.phtml';

if (file_exists($model)) {
    require $model;
}

$main_content = $_404;
if (file_exists($view)) {
    $main_content = $view;
}

// layout for guest
include_once $config['PATH2_VIEW'] . 'layout.phtml';
