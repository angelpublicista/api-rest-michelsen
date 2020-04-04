<?php
require './../vendor/autoload.php';
require './../src/config/db.php';

// Create and configure Slim app

$app = new \Slim\App;


// Define app routes
require './../src/routes/clientes.php';
require './../src/routes/creditos.php';

// Run app
$app->run();