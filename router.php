<?php

$router = [
	"GET" => [
		'league_table' => function($request, $response){
			$response->in_router = 'GET target - league_table';

			$response->league_table = (object)[
				'table_head' => [
					['title' => 'POS', 'description' => 'Position'],
					['title' => 'Team', 'description' => 'Team'],
					['title' => 'PTS', 'description' => 'Points'],
					['title' => 'PLD', 'description' => 'Played'],
					['title' => 'W', 'description' => 'Won'],
					['title' => 'D', 'description' => 'Drawn'],
					['title' => 'L', 'description' => 'Lost'],
					['title' => 'GD', 'description' => 'Goal difference'],
					['title' => 'PDC', 'description' => 'Predictions of Championship'],
				],
				'teams' => [
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
				]
			];

			return $response;
		},
		'weeks' => function($request, $response){
			$response->in_router = 'GET target - weeks';
			return $response;
		},
	],
	"POST" => [
		'weeks' => function($request, $response){
			$response->in_router = 'POST target - weeks';
			return $response;
		},
		'goals' => function($request, $response){
			$response->in_router = 'POST target - goals';
			return $response;
		},
	],
];

// $router->get['league_table'] = 'LeagueTableController@show';
// $router->get['weeks'] = 'LeagueWeeksController@show';
// $router->post['weeks'] = 'LeagueWeeksController@replay';
// $router->post['goals'] = 'TeamGoalsController@change_team_goals_in_match';



