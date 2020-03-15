<?php
use Base\Controller;
use Base\View;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$parts = explode('/', $_SERVER['REQUEST_URI']);
$controllerName = '\App\Controller\\' . ucfirst($parts[2] ?? 'index');
$action = stristr($parts[3], '?', true);
$actionName = ($action == false) ? ($parts[3] ?? 'index') : $action;

if (!class_exists($controllerName) || !method_exists($controllerName, $actionName)) {
    require '404.html';
    die;
}

$controller = new $controllerName();
$controller->$actionName();