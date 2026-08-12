<?php

use AFPA\Controller\HomeController;
use AFPA\Controller\PersonneController;

session_start();

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "init.php";

$router = new AltoRouter();

$router->map('GET', '/', 'HomeController#home');
$router->map('GET', '/contact', 'HomeController#contact', 'contact');
$router->map('GET', '/forum', 'HomeController#forum', 'forum');
$router->map('GET', '/forum/[*:slug]-[i:id]', 'HomeController#article', 'article');

// Routes pour Personne
$router->map('GET', '/personne', 'PersonneController#index', 'personne_index');
$router->map('GET', '/personne/create', 'PersonneController#create', 'personne_create');
$router->map('POST', '/personne', 'PersonneController#store', 'personne_store');
$router->map('GET', '/personne/[i:id]', 'PersonneController#show', 'personne_show');
$router->map('GET', '/personne/[i:id]/edit', 'PersonneController#edit', 'personne_edit');
$router->map('POST', '/personne/[i:id]', 'PersonneController#update', 'personne_update');
$router->map('POST', '/personne/[i:id]/delete', 'PersonneController#delete', 'personne_delete');

$GLOBALS['router'] = $router;

// La fonction addRouterToTwig() est déclarée dans config/init.php et chargée au début de ce fichier.
addRouterToTwig($router);

$match = $router->match();

if (is_array($match)) {
    $target = $match['target'];
    if (strpos($target, '#') !== false) {
        list($controllerName, $method) = explode('#', $target);
        $controllerClass = 'AFPA\\Controller\\' . $controllerName;
        $controller = new $controllerClass();
        call_user_func_array([$controller, $method], $match['params']);
    } elseif (is_callable($target)) {
        call_user_func_array($target, $match['params']);
    } else {
        $params = $match['params'];
        include dirname(__DIR__) . DIRECTORY_SEPARATOR . "controller" . DIRECTORY_SEPARATOR . $target . ".php";
    }
}
