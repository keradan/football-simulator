<?php

try {

	$request = (object)[];
	$request->type = $_SERVER['REQUEST_METHOD'];
	$request->data = (object)($_POST ? $_POST : $_GET);
	if(empty($request->data)) throw new Exception('request is empty.');

	$response = (object)[];
	$response->success = true;
	$response->request = $request;

	header('Content-Type: application/json');
	die(json_encode($response));

} catch (Exception $e) {
    die(json_encode([
		'success' => false,
		'error_msg' => $e->getMessage(),
	]));
}