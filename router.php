<?php

use Services\Team;
use Services\LeagueWeek;
use Services\LeagueMatch;
use Services\LeagueTable;
use Core\FileStorage;


// If you need to refresh some teams data, you cn do it with this route
$router->post('all_teams', function($request, $response) {
	// $teams = []; // take from storage/samples/teams
	foreach ($teams as $team) {
		FileStorage::getInstance()->store($team, $team->id, 'teams');
	}
	return $response->addData('all_teams_stored', true);
});

// get data for ligue table with all ligue results and scorings etc
$router->get('league_table', function($request, $response) {
	$league_table = new LeagueTable();

	$league_table_head_columns_data = $league_table->getColumnsHeadData();
	$league_table_body_teams_data = $league_table->getTotal();

	$table_head = $response->view->render('league-table-head', [
		'columns' => $league_table_head_columns_data,
	]);

	$table_body = $response->view->render('league-table-body', [
		'teams' => $league_table_body_teams_data,
		'columns' => $league_table_head_columns_data,
	]);

	return $response->addData('table_head', $table_head)->addData('table_body', $table_body);
});

// get next week id
$router->get('next_week_id', function($request, $response) {
	return $response->addData('next_week_id', LeagueWeek::nextWeekId());
});

// get data about all weeks
$router->get('weeks', function($request, $response) {
	$league_weeks = LeagueWeek::loadAll();

	$rendered_weeks_list = $response->view->render('league-weeks-list', compact('league_weeks'));

	return $response->addData('league_weeks_list', $rendered_weeks_list);
});

// get data about week by id
$router->get('week', function($request, $response) {
	$league_week = new LeagueWeek($request->data->week_id);

	$rendered_weeks_item = $response->view->render('league-weeks-list', [
		'league_weeks' => [$league_week->toDump()],
	]);
	
	return $response->addData('league_weeks_item', $rendered_weeks_item);
});

// play league week by week_id
$router->post('week', function($request, $response) {

	$league_week = new LeagueWeek($request->data->week_id);
	$league_week->run();

	return $response->addData('week_id', $league_week->id);
});

// remove all weeks, refresh toss tickets
$router->post('reset_league', function($request, $response) {

	// delete all weeks from storage
	LeagueWeek::deleteAll();

	// generate new toss pares for all league weeks
	$toss_tickets = LeagueTable::resetTossTickets();

	return $response->addData('new_toss_tickets', $toss_tickets);
});

// dsjkkjdsd
// $router->post('weeks', function($request, $response) {
// 	$response->addData('in_router', 'POST target - weeks');
// });

// dsjkdskjdjksdjks
$router->post('goals', function($request, $response) {	
	$league_week = new LeagueWeek($request->data->week_id);
	$league_week->updateGoal($request->data->match_id, $request->data->team, $request->data->goals);

	return $response->addData('ok', 'ok');
});



