<?php

namespace Core;

/**
 * Class for building response data
 */
class Response
{

	private $success;
	private $error_msg;
	private $request;
	
	public $view;
	
	public $data; // all of custom response data here
	
	public function __construct()
	{
		$this->success = true;
		$this->view = new View();
		$this->data = (object)[];
	}

	public function failWithError($error_msg)
	{
		$this->error_msg = $error_msg;
		$this->success = false;
	}
	
	public function __toString()
	{
		return json_encode([
			'success' => $this->success,
			'request' => $this->request->toDump(),
			'data' => $this->data ?? null,
			'error_msg' => $this->error_msg ?? null,
		]);
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

	public function addData($name, $value)
	{
		$this->data->{$name} = $value;
		return $this;
	}

}