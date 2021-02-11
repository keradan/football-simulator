<?php

namespace Core;

/**
 * Class for rendering HTML code
 */
class View
{
	
	public function render($view_name, $data)
	{
		extract($data);

		ob_start();

		require $_SERVER["DOCUMENT_ROOT"] . '/view/' . implode('/', explode('.', $view_name)) . '.php';

		$rendered = ob_get_contents();

		ob_end_clean();

		return $rendered;
	}
}