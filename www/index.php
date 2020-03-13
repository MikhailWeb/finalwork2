<?php
use Base\Controller;
use Base\View;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$parts = explode('/', $_SERVER['REQUEST_URI']);
$controllerName = '\App\Controller\\' . ucfirst($parts[2] ?? 'index');
$action = stristr($parts[3], '?', true);
$actionName = ($action == false) ? ucfirst($parts[3] ?? 'index') : $action;
//$actionName = ucfirst($parts[3] ?? 'index');

$controller = new $controllerName();

if (!method_exists($controller, $actionName)) {
    die('Action "' . $actionName . '" not found in controller "' . ucfirst($parts[2] ?? 'index') .'"');
}

$view = new View();
$controller->setView($view->setTemplatePath(__DIR__ . '/../app/view'));
$controller->$actionName();