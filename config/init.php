<?php

use Twig\Extension\DebugExtension;

$loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views');
$twig = new \Twig\Environment($loader , [
    'debug' => true
]);
$twig->addExtension(new DebugExtension);
$twig->addGlobal('session', $_SESSION);

// Database connection
try {
    $pdo = new PDO('mysql:host=db;dbname=demo;charset=utf8', 'test', 'pass');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// CSRF Token functions
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function addRouterToTwig($router) {
    global $twig;
    require_once 'RouterExtension.php';
    $twig->addExtension(new RouterExtension($router));
    $twig->addGlobal('csrf_token', generateCSRFToken());
}