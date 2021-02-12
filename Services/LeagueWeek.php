<?php

namespace Services;

use Core\FileStorage;
use Services\Team;

/**
 * 
 */
class LeagueWeek
{

	private $last_league_week_data;
	private $league_week_data;
	
	public function __construct($week_id)
	{
		if (FileStorage::getInstance()->is_exists($week_id - 1, 'weeks'))
			$this->last_league_week_data = FileStorage::getInstance()->load($week_id - 1, 'weeks');

		if (FileStorage::getInstance()->is_exists($week_id, 'weeks'))
			$this->league_week_data = FileStorage::getInstance()->load($week_id, 'weeks');
		else {
			$this->league_week_data = (object)[];
			$this->league_week_data->id = $week_id;
			$this->league_week_data->matches = [];
			$this->league_week_data->teams_results = [];
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

		foreach ($matches as $match) {
			$this->teams_results[$match->owner->id] = $this->getTeamResult($match->owner, $match->guest);
			$this->teams_results[$match->guest->id] = $this->getTeamResult($match->guest, $match->owner);
		}

		return $this;
	}

	private function getWeekTeamResult($team, $rival_team)
	{
		$team_result = (object)[
			'team_id' => $team->id,
			'name' => $team->name,
			'pts' => $team->points,
			'pld' => $this->id,
			'w' => (int)($team->points == 3),
			'd' => (int)($team->points == 1),
			'l' => (int)($team->points == 0),
			'gd' => $team->goals - $rival_team->goals,
		];
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