<?php

namespace Services;

use Core\FileStorage;
use Services\Team;

/**
 * 
 */
class LeagueWeek
{

	private $league_week_data;
	
	public function __construct($week_id)
	{
		$this->league_week_data = FileStorage::getInstance()->load($week_id, 'weeks');
	}

	public static function loadAll()
	{
		foreach (FileStorage::getInstance()->getDirFileNames('weeks') as $week_id) {
			$all_teams[] = new static($week_id);
		}
		return $all_teams;
	}

	public static function loadById($week_id)
	{
		return new static($week_id);
	}

	public static function storeById($week_id, $week_data)
	{
		$operation_result = FileStorage::getInstance()->store($week_data, $week_id, 'weeks');
		if (!$operation_result) return false;
		return new static($week_id);
	}

	public function run($week_id)
	{
		$week_tickets = explode('|', FileStorage::getInstance()->load('toss_tickets')[$week_id]);
	}

	public function __get($property)
	{
		if (property_exists($this, $property)) return $this->$property;
		return $this->team_data->$property;
	}

}