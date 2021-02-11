<?php

namespace Core;

/**
 * 
 */
class Router
{
	private $get = [];
	private $post = [];

	public function __construct()
	{
		$router = $this;
		require_once $_SERVER["DOCUMENT_ROOT"] . '/router.php';
	}

	public function get($target, $closure)
	{
		$this->get[$target] = $closure;
	}

	public function post($target, $closure)
	{
		$this->post[$target] = $closure;
	}

	public function run($request, $response)
	{
		$response->setRequest($request);
		
		$current_method_routes = $this->{$request->method};

		if (!isset($current_method_routes[$request->data->target]))
			throw new \Exception("Route does not exists: " . $request->method . ' - ' . $request->data->target);
		
		$response = $current_method_routes[$request->data->target]($request, $response);
		
		return $response;
	}
}






