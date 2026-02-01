<?php
// Show PHP errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';
// Load config
require __DIR__ . '/../src/Services/conn.php'; // defines $pdo
session_start();
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;

$app = AppFactory::create();

$app->addRoutingMiddleware();
// Create container
include __DIR__ . '/../src/config.php';

// Add error middleware (this is required to see Slim errors)
$app->addErrorMiddleware(true, true, true);

// Load your routes
(require __DIR__ . '/../routes/web.php')($app, $pdo);

$app->run();