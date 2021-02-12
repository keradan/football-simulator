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
		if (FileStorage::getInstance()->is_exists($week_id, 'weeks'))
			$this->league_week_data = FileStorage::getInstance()->load($week_id, 'weeks');
		else {
			$this->league_week_data = (object)[];
			$this->league_week_data->id = $week_id;
			$this->league_week_data->matches = [];
		}
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

	public function save()
	{
		self::storeById($this->id, $this->league_week_data);
		return $this;
	}

	public static function storeById($week_id, $week_data)
	{
		$operation_result = FileStorage::getInstance()->store($week_data, $week_id, 'weeks');
		if (!$operation_result) return false;
		return new static($week_id);
	}

	public function run()
	{
	
		$toss_ticket = FileStorage::getInstance()->load('toss_tickets')[$this->id];

		foreach (explode('|', $toss_ticket) as $match_toss_ticket) {
			$match = new LeagueMatch($match_toss_ticket);
			$matches[] = $match->run()->getMatchResults();
		}
		$this->matches = $matches;
		return $this;
	}

	public function toDump()
	{
		return $this->league_week_data;
	}

	public function __get($property)
	{
		if (property_exists($this, $property)) return $this->$property;
		return $this->league_week_data->$property;
	}

	public function __set($property, $value)
	{
		if (property_exists($this, $property)) return;
		return $this->league_week_data->$property = $value;
	}

}