<?php
require './../vendor/autoload.php';
require './../src/config/db.php';

// Create and configure Slim app

$app = new \Slim\App;


// Define app routes
require './../src/rutas/clientes.php';

// Run app
$app->run();