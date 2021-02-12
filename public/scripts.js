function api_call(method, data, success_function = null) {
	$.ajax({
		url: window.location.href + 'api.php',
		data: data,
		dataType: 'json',
		method: method,
		success: success_function ?? function(response) {
			console.log(response);
		},
		error: function(error){
			console.log(error);
		},
	});
}

let api_get = (data, success_function = null) => api_call('get', data, success_function);
let api_post = (data, success_function = null) => api_call('post', data, success_function);

let next_week_id = 1;

// какие мне нужны запросы к апи:
// api_get({target:'test'})
// api_post({target:'reset_league'})

// 2 пересчитать неделю по номеру api_post({target:'weeks', week_id: 5})

// 4 пересчитать все недели api_post({target:'weeks'})

// 6 изменить голы оунера api_post({target:'goals', week_id: 5, match_id: 2, team: 'owner'})
// 7 изменить голы гуеста api_post({target:'goals', week_id: 5, match_id: 2, team: 'guest'})

// Fill the main league table with actual data in html, rendered from api
function refresh_league_table () {
	let table = document.querySelector('table.league-table');
	table.classList.toggle('loading', true);

	api_get({target: 'league_table'}, function(response){
		console.log('response: ', response);
		
		table.querySelector('thead').innerHTML = response.data.table_head;
		table.querySelector('tbody').innerHTML = response.data.table_body;

		table.classList.toggle('loading', false);
	})
}

// Reset and fill the weeks list with actual data in html, rendered from api
function refresh_league_weeks () {
	api_get({target: 'weeks'}, function(response) {
		console.log('response: ', response);

		document.querySelector('.league-week-list').innerHTML = response.data.league_weeks_list;
		listen_goals_edits();
	});
}

// Get next week data and put it in the end of the weeks list
function add_next_week (week_id) {
	if (next_week_id > 6) return false;
	api_get({target: 'week', week_id: week_id}, function(response) {
		console.log('response: ', response);

		document.querySelector('.league-week-list').innerHTML += response.data.league_weeks_item;
		listen_goals_edits();

		get_next_week_id();
	});
}

// Run next week, by "next_week_id" variable
function play_next_week () {
	if (next_week_id > 6) return false;
	api_post({target: 'week', week_id: next_week_id}, function(response) {
		console.log('response: ', response);

		refresh_league_table();
		add_next_week(response.data.week_id);
	});
}

function listen_goals_edits() {
	document.querySelectorAll('table.week-matches th input').forEach(function(input) {
		input.addEventListener('change', function() {
			input.classList.toggle('changed', input.value != input.dataset.oldValue);
		});
	});
}

function reset_league() {
	api_post({target: 'reset_league'}, function(response) {
		console.log('response: ', response);

		let table = document.querySelector('table.league-table');
		table.querySelector('thead').innerHTML = '';
		table.querySelector('tbody').innerHTML = '';
		document.querySelector('.league-week-list').innerHTML = '';

		next_week_id = 1;
	});
}

function get_next_week_id() {
	api_get({target: 'next_week_id'}, function(response) {
		console.log('response: ', response);

		next_week_id = response.data.next_week_id;
		if(next_week_id > 6) {
			document.querySelector('.next-week-button').remove();
			document.querySelector('.all-weeks-button').remove();
		}
	});
}



get_next_week_id();
refresh_league_table();
refresh_league_weeks();



