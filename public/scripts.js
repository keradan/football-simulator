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

let number_of_week = 1;

// какие мне нужны запросы к апи:

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
		
		table.querySelector('thead').innerHTML = response.league_table.head;
		table.querySelector('tbody').innerHTML = response.league_table.body;

		table.classList.toggle('loading', false);
	})
}

// Reset and fill the weeks list with actual data in html, rendered from api
function refresh_league_weeks () {
	api_get({target: 'weeks'}, function(response) {
		console.log('response: ', response);

		document.querySelector('.league-week-list').innerHTML = response.league_weeks_list;
		listen_goals_edits();
	});
}

// Get only one week, next by "number_of_week" variable, and put it in the end of the weeks list
function play_next_week () {
	api_get({target: 'weeks', week_id: number_of_week}, function(response) {
		console.log('response: ', response);

		document.querySelector('.league-week-list').innerHTML += response.league_weeks_item;
		listen_goals_edits();

		number_of_week++;
	});
}

function listen_goals_edits() {
	document.querySelectorAll('table.week-matches th input').forEach(function(input) {
		input.addEventListener('change', function() {
			input.classList.toggle('changed', input.value != input.dataset.oldValue);
		});
	});
}



refresh_league_table();
refresh_league_weeks();



