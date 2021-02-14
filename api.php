<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

// Request initialization
$request = new \Core\Request();

// Response initialization
$response = new \Core\Response();

// Router Initialization
$router = new \Core\Router();

header('Content-Type: application/json');

try {

	if($request->isEmpty()) throw new Exception('request is empty.');

	die($router->run($request, $response));

} catch (Exception $e) {

	$response->failWithError($e->getMessage());

    die($response);
    
}
