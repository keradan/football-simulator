<?php

namespace Services;

use Core\FileStorage;
use Services\Team;
use Services\LeagueWeek;


/**
 * 
 */
class LeagueTable
{

	private $league_table_data = [];
	
	public function __construct()
	{
		// if (FileStorage::getInstance()->is_exists('league_table'))
			// $this->league_table_data = FileStorage::getInstance()->load('league_table');
	}

	public function save()
	{
		// FileStorage::getInstance()->store($this->league_table_data, 'league_table');
	}

	// Need to change this slow method, by something more efficient
	public function getTotal()
	{
		$weeks_ids = FileStorage::getInstance()->getDirFileNames('weeks');

		$all_teams = Team::loadAll();

		foreach ($all_teams as $team) {
			$totals[$team->id] = (object)[
				'team_id' => $team->id,
				'Team' => $team->name,
				'PTS' => 0,
				'PLD' => max(array_merge($weeks_ids, [0])),
				'W' => 0,
				'D' => 0,
				'L' => 0,
				'GD' => 0,
				'numeric_pdc' => 0,
			];
		}

		foreach ($weeks_ids as $week_id) {
			$week = new LeagueWeek($week_id);
			foreach ($week->teams_results as $team_week_result) {
				$team_totals = $totals[$team_week_result->team_id];

				$team_totals->PTS = $team_totals->PTS + $team_week_result->PTS;
				$team_totals->W = $team_totals->W + $team_week_result->W;
				$team_totals->D = $team_totals->D + $team_week_result->D;
				$team_totals->L = $team_totals->L + $team_week_result->L;
				$team_totals->GD = $team_totals->GD + $team_week_result->GD;
				$team_totals->numeric_pdc = max(1, $team_totals->PTS + $team_totals->W - $team_totals->L + ($team_totals->GD));

				$totals[$team_week_result->team_id] = $team_totals;
			}
		}

		$common_numeric_pdc = array_reduce($totals, function($carry, $team_totals) {
			return $carry + $team_totals->numeric_pdc;
		});

		foreach ($totals as $team_id => &$team_totals) {
			if($common_numeric_pdc <= 0) {
				$team_totals->PDC = 25 . '%';
			} else $team_totals->PDC = round(($team_totals->numeric_pdc / $common_numeric_pdc) * 100) . '%';

		}

		usort($totals, function ($a, $b) {
			return $b->PTS > $a->PTS;
		});

		return $totals;
	}

	public static function load()
	{
		return new static();
	}

	public function setColumnsHeadData()
	{
		// here we can store some defaults
		FileStorage::getInstance()->store([], 'league_table_columns_head');
	}

	public function getColumnsHeadData()
	{
		return FileStorage::getInstance()->load('league_table_columns_head');
	}

	public static function resetTable()
	{
		// if (FileStorage::getInstance()->is_exists('league_table'))
			// return FileStorage::getInstance()->delete('league_table');
		// else return false;
	}
	
	public static function resetTossTickets()
	{
		// Should generate team pares algorythmic way, but for now tmp:
		$toss_tickets[] = "1-2|3-4";
		$toss_tickets[] = "1-3|2-4";
		$toss_tickets[] = "1-4|3-2";
		$toss_tickets[] = "2-3|4-1";
		$toss_tickets[] = "2-1|4-3";
		$toss_tickets[] = "3-1|4-2";

		shuffle($toss_tickets);

		FileStorage::getInstance()->store($toss_tickets, 'toss_tickets');
		$toss_tickets = FileStorage::getInstance()->load('toss_tickets');

		return $toss_tickets;
	}

}