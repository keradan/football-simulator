<?php

namespace Services;

use Core\FileStorage;
use Services\Team;
use Services\LeagueTable;

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

	public static function deleteAll()
	{
		foreach (FileStorage::getInstance()->getDirFileNames('weeks') as $week_id) {
			if (FileStorage::getInstance()->is_exists($week_id, 'weeks'))
				$is_deleted[$week_id] = FileStorage::getInstance()->delete($week_id, 'weeks');
		}
		return $is_deleted ?? null;
	}

	public static function nextWeekId()
	{
		$weeks_ids = FileStorage::getInstance()->getDirFileNames('weeks');
		return max(array_merge($weeks_ids, [0])) + 1;
	}

	public static function loadAll()
	{
		foreach (FileStorage::getInstance()->getDirFileNames('weeks') as $week_id) {
			$all_weeks[] = new static($week_id);
		}
		return $all_weeks ?? [];
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
		if ($this->id > 6) return null;
		$week_match_toss_tickets = explode('|', FileStorage::getInstance()->load('toss_tickets')[$this->id - 1]);

		foreach ($week_match_toss_tickets as $match_toss_ticket) {
			$match = new LeagueMatch($match_toss_ticket);
			$matches[] = $match->run()->getMatchResults();

			$this->league_week_data->teams_results[$match->owner->id] = $this->getWeekTeamResult($match->owner, $match->guest);
			$this->league_week_data->teams_results[$match->guest->id] = $this->getWeekTeamResult($match->guest, $match->owner);
		}

		$this->matches = $matches;

		$this->save();

		$league_table = new LeagueTable();

		return $this;
	}

	private function getWeekTeamResult($team, $rival_team)
	{
		return (object)[
			'team_id' => $team->id,
			'Team' => $team->name,
			'PTS' => $team->points,
			'PLD' => $this->id,
			'W' => (int)($team->points == 3),
			'D' => (int)($team->points == 1),
			'L' => (int)($team->points == 0),
			'GD' => $team->goals - $rival_team->goals,
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