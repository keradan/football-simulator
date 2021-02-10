<?php

$router->GET['league_table'] = function($request, $response) { // LeagueTableController@show
	$league_table_head_columns = [
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

	$league_table_body_teams = [
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

	$response->league_table = (object)[
		'head' => $response->view->render('league-table-head', [
			'columns' => $league_table_head_columns,
		]),
		'body' => $response->view->render('league-table-body', [
			'teams' => $league_table_body_teams,
		]),
	];

	return $response;
};

$router->GET['weeks'] = function($request, $response) { // 'LeagueWeeksController@show'
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

	if (isset($request->data->week_id)) {
		$response->league_weeks_item = $response->view->render('league-weeks-list', [
			'league_weeks' => [$league_weeks[$request->data->week_id - 1]],
		]);
	} else {
		$response->league_weeks_list = $response->view->render('league-weeks-list', compact('league_weeks'));
	}

	return $response;
};

$router->POST['weeks'] = function($request, $response) { // 'LeagueWeeksController@replay'
	$response->in_router = 'POST target - weeks';
	return $response;
};

$router->POST['goals'] = function($request, $response) { // 'TeamGoalsController@change_team_goals_in_match'
	$response->in_router = 'POST target - goals';
	return $response;
};



