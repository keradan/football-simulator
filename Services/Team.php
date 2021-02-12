<?php

namespace Services;

use Core\FileStorage;

/**
 * 
 */
class Team
{

	private $team_data;
	
	public function __construct($team_id)
	{
		$this->team_data = FileStorage::getInstance()->load($team_id, 'teams');
	}

	public static function loadAll()
	{
		foreach (FileStorage::getInstance()->getDirFileNames('teams') as $team_id) {
			$all_teams[] = new static($team_id);
		}
		return $all_teams;
	}

	public static function loadById($team_id)
	{
		return new static($team_id);
	}

	public function __get($property)
	{
		if (property_exists($this, $property)) return $this->$property;
		return $this->team_data->$property;
	}

	public function __set($property, $value)
	{
		if (property_exists($this, $property)) return;
		return $this->team_data->$property = $value;
	}

}