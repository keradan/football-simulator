<?php
$request = $_POST ? $_POST : $_GET;
if(empty($request)) die(json_encode([
	'success' => false,
	'error' => 'request is empty',
])); 

$request = (object)$request;
$request->type = $_SERVER['REQUEST_METHOD'];

$data = [
	'success' => true,
	'request' => $request,
	'data' => 'sdhjdsdshj',
];
header('Content-Type: application/json');
die(json_encode($data));