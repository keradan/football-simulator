<?php

require_once 'vendor/autoload.php';

$request = (object)[];
$request->type = $_SERVER['REQUEST_METHOD'];
$request->data = (object)($_POST ? $_POST : $_GET);

$response = (object)[];
$response->success = true;
$response->request = $request;
$response->view = new \Core\View();

$router = (object)["GET" => [], "POST" => []];
require 'router.php';

try {

	if(empty((array)$request->data)) throw new Exception('request is empty.');

	// die(print_r($router));

	header('Content-Type: application/json');
	die(json_encode($router->{$request->type}[$request->data->target]($request, $response)));

} catch (Exception $e) {
    die(json_encode([
		'success' => false,
		'request' => $request,
		'error_msg' => $e->getMessage(),
	]));
}