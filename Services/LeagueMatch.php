<?php

namespace Services;

use Core\FileStorage;
use Services\Team;

/**
 * 
 */
class LeagueMatch
{

	private $home_field_advantage = 15;

	private $match_rounds = 4;

	private $owner;
	private $guest;
	
	private $winner_team_id;
	private $rounds_log = [];
	
	public function __construct($match_ticket)
	{	
		$match_ticket = explode('-', $match_ticket);
		$this->owner = FileStorage::getInstance()->load($match_ticket[0], 'teams');
		$this->guest = FileStorage::getInstance()->load($match_ticket[1], 'teams');

		$this->owner->goals = 0;
		$this->guest->goals = 0;

		$this->owner->points = 0;
		$this->guest->points = 0;
	}

	public function run()
	{
		$owner_players_count = 11;
		$guest_players_count = 11;
		for ($i = 0; $i < $this->match_rounds; $i++) {

			$owner_players_count_coef = ($owner_players_count / (11 * 1.5));
			$guest_players_count_coef = ($guest_players_count / (11 * 1.5));

			$owner_atack = round($owner_players_count_coef * ((0.7 * $this->owner->spi) * (0.5 * $this->owner->offensive) + rand(1, 40) + $this->home_field_advantage));

			$guest_atack = round($guest_players_count_coef * ((0.7 * $this->guest->spi) * (0.5 * $this->guest->offensive) + rand(1, 40)));

			$owner_defense = round($owner_players_count_coef * ((0.7 * $this->owner->spi) - (30 * $this->owner->defensive) + rand(1, 40) + $this->home_field_advantage));

			$guest_defense = round($guest_players_count_coef * ((0.7 * $this->guest->spi) - (30 * $this->guest->defensive) + rand(1, 40)));

			$owners_goal_ratio = $owner_atack / $guest_defense;
			$guest_goal_ratio = $guest_atack / $owner_defense;

			$new_owner_goals = 0;
			if ($owners_goal_ratio > 4.5) $new_owner_goals = 3;
			elseif ($owners_goal_ratio > 3.3) $new_owner_goals = 2;
			elseif ($owners_goal_ratio > 1.8) $new_owner_goals = 1;
			$this->owner->goals = $this->owner->goals + $new_owner_goals;

			$new_guest_goals = 0;
			if ($guest_goal_ratio > 4.5) $new_guest_goals = 3;
			elseif ($guest_goal_ratio > 3.3) $new_guest_goals = 2;
			elseif ($guest_goal_ratio > 1.8) $new_guest_goals = 1;
			$this->guest->goals = $this->guest->goals + $new_guest_goals;

			$this->rounds_log[$i] = (object)[
				'owner_atack' => $owner_atack,
				'guest_atack' => $guest_atack,
				'owner_defense' => $owner_defense,
				'guest_defense' => $guest_defense,
				'owners_goal_ratio' => $owners_goal_ratio,
				'guest_goal_ratio' => $guest_goal_ratio,
				'new_owner_goals' => $new_owner_goals,
				'new_guest_goals' => $new_guest_goals,
				'owner_players_count' => $owner_players_count,
				'guest_players_count' => $guest_players_count,
			];

			if (rand(1, 100) > 90) $owner_players_count--;
			if (rand(1, 100) > 90) $guest_players_count--;
		}

		if ($this->owner->goals == $this->guest->goals) {
			$this->owner->points = 1;
			$this->guest->points = 1;
		}

		if ($this->owner->goals > $this->guest->goals) {
			$this->winner_team_id = $this->owner->id;
			$this->owner->points = 3;
		}
		if ($this->owner->goals < $this->guest->goals) {
			$this->winner_team_id = $this->guest->id;
			$this->guest->points = 3;
		}

		return $this;
	}

	public function getMatchResults()
	{
		return (object)[
			'winner_team_id' => $this->winner_team_id,
			'rounds_log' => $this->rounds_log,
			'owner' => (object)[
				'name' => $this->owner->name,
				'goals' => $this->owner->goals,
				'points' => $this->owner->points,
			],
			'guest' => (object)[
				'name' => $this->guest->name,
				'goals' => $this->guest->goals,
				'points' => $this->guest->points,
			],
		];
	}

}