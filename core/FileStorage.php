<?php

namespace Core;

/**
 * Class for handling disk storing of data 
 */
class FileStorage
{

	private static $instance = null;

	private $storage_dir;
	
	/**
     * is not allowed to call from outside to prevent from creating multiple instances,
     */
    private function __construct()
    {
    	$this->storage_dir = $_SERVER["DOCUMENT_ROOT"] . '/storage';
    }

    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone()
    {
    }

    /**
     * prevent from being unserialized (which would create a second instance of it)
     */
    private function __wakeup()
    {
    }

    public static function getInstance(): FileStorage
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

	public function is_exists(string $name, string $dir = '')
	{
		return file_exists($this->get_path($name, $dir));
	}

	public function store($data, string $name, string $dir = '')
	{
		$path = $this->get_path($name, $dir);

		$operation_result = file_put_contents($path, bzcompress(serialize($data)));

		if($operation_result === false) throw new \Exception("Failed to store file: " . $path);
		
		return $operation_result;
	}

	public function getDirFileNames(string $dir = '')
	{
		$dir = implode(DIRECTORY_SEPARATOR, array_merge([$this->storage_dir], explode('/', $dir)));
		
		$files_list = scandir($dir);
		
		if($files_list === false) throw new \Exception("Failed to get file names of dir: " . $dir);
		
		return array_values(array_diff($files_list, ['..', '.']));
	}

	public function load(string $name, string $dir = '')
	{
		$path = $this->get_path($name, $dir);

		$data = file_get_contents($path);

		if($data === false) throw new \Exception("Failed to load file: " . $path);
		
		return unserialize(bzdecompress($data));
	}

	public function delete(string $name, string $dir = '')
	{
		$path = $this->get_path($name, $dir);

		if(!$this->is_exists($name, $dir)) throw new \Exception("Attempt to delete non existing file: " . $path);

		$operation_result = unlink($path);

		if (!$operation_result) throw new \Exception("Failed to delete file: " . $path);

		return true;
	}

	private function get_path(string $name, string $dir = '')
	{
		return implode(DIRECTORY_SEPARATOR, array_merge([$this->storage_dir], explode('/', $dir), [$name]));
	}
	
}