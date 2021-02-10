<?php

$request = (object)[];
$request->type = $_SERVER['REQUEST_METHOD'];
$request->data = (object)($_POST ? $_POST : $_GET);

$response = (object)[];
$response->success = true;
$response->request = $request;

$router = [
	"GET" => [
		'league_table' => function($request, $response){
			$response->in_router = 'target - league_table';
			return $response;
		},
		'weeks' => function($request, $response){
			$response->in_router = 'target - weeks';
			return $response;
		},
	],
	"POST" => [
		'weeks' => function($request, $response){
			$response->in_router = 'target - weeks';
			return $response;
		},
		'goals' => function($request, $response){
			$response->in_router = 'target - goals';
			return $response;
		},
	],
];

try {

	if(empty((array)$request->data)) throw new Exception('request is empty.');

	header('Content-Type: application/json');
	die(json_encode($router[$request->type][$request->data->target]($request, $response)));

} catch (Exception $e) {
    die(json_encode([
		'success' => false,
		'request' => $request,
		'error_msg' => $e->getMessage(),
	]));
}