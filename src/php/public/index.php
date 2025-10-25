<?php

require_once __DIR__ . '/../app/core/router.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';

// --- Define Routes ---

$routes = [
    '/' => [
        'controller' => 'HomeController',
        'method' => 'index'
    ],
    '/home' => [
        'controller' => 'HomeController',
        'method' => 'index'
    ]
];

$router = new Routes($routes);
$router->handleRequest();