<?php

namespace Core;

/**
 * Class for handling request data
 */
class Request
{

	private $method;
	private $data;
	
	public function __construct()
	{
		$this->method = strtolower($_SERVER['REQUEST_METHOD']);
		$this->data = (object)($_POST ? $_POST : $_GET);
	}

	public function isEmpty()
	{
		return empty((array)$this->data);
	}

	public function toDump()
	{
		return (object)[
			'method' => $this->method,
			'data' => $this->data,
		];
	}

	public function __get($property) {
		if (!property_exists($this, $property)) return null;
		return $this->$property;
	}

}