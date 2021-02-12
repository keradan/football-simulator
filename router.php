<?php

use Services\Team;
use Services\LeagueWeek;
use Services\LeagueMatch;
use Core\FileStorage;

$router->post('all_teams', function($request, $response) {
	// take from storage/samples/teams
	$teams = [
		(object)[
			'id' => 1,
			'name' => 'Manchester City',
			'spi' => 87.8,
			'offensive' => 2.4,
			'defensive' => 0.3,
		],
		(object)[
			'id' => 2,
			'name' => 'West Ham',
			'spi' => 76.0,
			'offensive' => 2.0,
			'defensive' => 0.7,
		],
		(object)[
			'id' => 3,
			'name' => 'Newcastle',
			'spi' => 62.8,
			'offensive' => 1.7,
			'defensive' => 0.9,
		],
		(object)[
			'id' => 4,
			'name' => 'Leicester City',
			'spi' => 80.0,
			'offensive' => 2.1,
			'defensive' => 0.5,
		],
	];
	foreach ($teams as $team) {
		FileStorage::getInstance()->store($team, $team->id, 'teams');
	}
	return $response->addData('all_teams_stored', true);
});

$router->get('all_teams', function($request, $response) {
	$all_teams = array_map(function($team){
		return [
			'id' => $team->id,
			'name' => $team->name,
		];
	}, Team::loadAll());

	return $response->addData('all_teams', $all_teams);
});

$router->get('test', function($request, $response) {
	
	$toss_tickets[] = "1-2|3-4";
	$toss_tickets[] = "1-3|2-4";
	$toss_tickets[] = "1-4|3-2";
	$toss_tickets[] = "2-3|4-1";
	$toss_tickets[] = "2-1|3-1";
	$toss_tickets[] = "4-2|4-3";

	foreach ($toss_tickets as $toss_ticket) {
		$tickets = explode('|', $toss_ticket);
		$match = new LeagueMatch($tickets[0]);
		$match_results[] = $match->run()->getMatchResults();

		$match = new LeagueMatch($tickets[1]);
		$match_results[] = $match->run()->getMatchResults();
	}

	return $response->addData('match_results', $match_results);
});

// get data for ligue table with all ligue results and scorings etc
$router->get('league_table', function($request, $response) {
	$league_table_head_columns_data = [
		(object)['title' => 'POS', 'description' => 'Position'],
		(object)['title' => 'Team', 'description' => 'Team'],
		(object)['title' => 'PTS', 'description' => 'Points'],
		(object)['title' => 'PLD', 'description' => 'Played'],
		(object)['title' => 'W', 'description' => 'Won'],
		(object)['title' => 'D', 'description' => 'Drawn'],
		(object)['title' => 'L', 'description' => 'Lost'],
		(object)['title' => 'GD', 'description' => 'Goal difference'],
		(object)['title' => 'PDC', 'description' => 'Predictions of Championship'],
	];

	$league_table_body_teams_data = [
		(object)[
			'POS' => '1',
			'Team' => 'Leicester City',
			'PTS' => '81',
			'PLD' => '15',
			'W' => '23',
			'D' => '12',
			'L' => '3',
			'GD' => '+25',
			'PDC' => '56%',
		],
		(object)[
			'POS' => '2',
			'Team' => 'Arsenal',
			'PTS' => '70',
			'PLD' => '15',
			'W' => '20',
			'D' => '11',
			'L' => '6',
			'GD' => '+12',
			'PDC' => '43%',
		],
		(object)[
			'POS' => '3',
			'Team' => 'Tottenham Hotspur',
			'PTS' => '64',
			'PLD' => '14',
			'W' => '18',
			'D' => '8',
			'L' => '6',
			'GD' => '+5',
			'PDC' => '23%',
		],
		(object)[
			'POS' => '4',
			'Team' => 'Manchester City',
			'PTS' => '62',
			'PLD' => '14',
			'W' => '17',
			'D' => '9',
			'L' => '8',
			'GD' => '-3',
			'PDC' => '5%',
		],
	];

	$table_head = $response->view->render('league-table-head', [
		'columns' => $league_table_head_columns_data,
	]);

	$table_body = $response->view->render('league-table-body', [
		'teams' => $league_table_body_teams_data,
	]);

	return $response->addData('table_head', $table_head)->addData('table_body', $table_body);
});

// get data about week by id
$router->get('week', function($request, $response) {
	$league_weeks = [
		(object)[
			'id' => 1,
			'status' => 'completed',
			'matches' => [
				(object)[
					'owner' => (object)[
						'name' => 'Tottenham Hotspur',
						'goals' => 3,
					],
					'guest' => (object)[
						'name' => 'Manchester City',
						'goals' => 2,
					],
				],
				(object)[
					'owner' => (object)[
						'name' => 'Leicester City',
						'goals' => 1,
					],
					'guest' => (object)[
						'name' => 'Arsenal',
						'goals' => 4,
					],
				],
			],
		],
		(object)[
			'id' => 2,
			'status' => 'started',
			'matches' => [
				(object)[
					'owner' => (object)[
						'name' => 'Tottenham Hotspur',
						'goals' => 2,
					],
					'guest' => (object)[
						'name' => 'Arsenal',
						'goals' => 2,
					],
				],
			],
		],
		(object)[
			'id' => 3,
			'status' => 'not_started',
			'matches' => [],
		],
		(object)[
			'id' => 4,
			'status' => 'not_started',
			'matches' => [],
		],
		(object)[
			'id' => 5,
			'status' => 'not_started',
			'matches' => [],
		],
	];

	$rendered_weeks_item = $response->view->render('league-weeks-list', [
		'league_weeks' => [$league_weeks[$request->data->week_id - 1]],
	]);
	
	return $response->addData('league_weeks_item', $rendered_weeks_item);
});

// get data about all weeks
$router->get('weeks', function($request, $response) {
	$league_weeks = [
		(object)[
			'id' => 1,
			'status' => 'completed',
			'matches' => [
				(object)[
					'owner' => (object)[
						'name' => 'Tottenham Hotspur',
						'goals' => 3,
					],
					'guest' => (object)[
						'name' => 'Manchester City',
						'goals' => 2,
					],
				],
				(object)[
					'owner' => (object)[
						'name' => 'Leicester City',
						'goals' => 1,
					],
					'guest' => (object)[
						'name' => 'Arsenal',
						'goals' => 4,
					],
				],
			],
		],
		(object)[
			'id' => 2,
			'status' => 'started',
			'matches' => [
				(object)[
					'owner' => (object)[
						'name' => 'Tottenham Hotspur',
						'goals' => 2,
					],
					'guest' => (object)[
						'name' => 'Arsenal',
						'goals' => 2,
					],
				],
			],
		],
		(object)[
			'id' => 3,
			'status' => 'not_started',
			'matches' => [],
		],
		(object)[
			'id' => 4,
			'status' => 'not_started',
			'matches' => [],
		],
		(object)[
			'id' => 5,
			'status' => 'not_started',
			'matches' => [],
		],
	];

	$rendered_weeks_list = $response->view->render('league-weeks-list', compact('league_weeks'));

	return $response->addData('league_weeks_list', $rendered_weeks_list);
});

// play league week byweek_id
$router->post('week', function($request, $response) {
	$response->addData('in_router', 'POST target - weeks');
});

// remove all weeks, refresh toss tickets
$router->post('reset_league', function($request, $response) {
	// $all_teams = Team::loadAll();

	// $weeks_count = (count($all_teams) * (count($all_teams) - 1)) / 2;

	$toss_tickets[] = "1-2|3-4";
	$toss_tickets[] = "1-3|2-4";
	$toss_tickets[] = "1-4|3-2";
	$toss_tickets[] = "2-3|4-1";
	$toss_tickets[] = "2-1|3-1";
	$toss_tickets[] = "4-2|4-3";

	shuffle($toss_tickets);

	FileStorage::getInstance()->store($toss_tickets, 'toss_tickets');
	$toss_tickets = FileStorage::getInstance()->load('toss_tickets');

	return $response->addData('toss_tickets', $toss_tickets);
});

// dsjkkjdsd
$router->post('weeks', function($request, $response) {
	$response->addData('in_router', 'POST target - weeks');
});

// dsjkdskjdjksdjks
$router->post('goals', function($request, $response) {
	$response->addData('in_router', 'POST target - goals');
});



