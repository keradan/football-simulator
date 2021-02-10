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
// 3 достать данные недели по номеру api_get({target:'weeks', week_id: 5})
// 4 пересчитать все недели api_post({target:'weeks'})
// 5 достать данные всех недель api_get({target:'weeks'})
// 6 изменить голы оунера api_post({target:'goals', week_id: 5, match_id: 2, team: 'owner'})
// 7 изменить голы гуеста api_post({target:'goals', week_id: 5, match_id: 2, team: 'guest'})

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

function refresh_league_weeks () {
	api_get({target: 'weeks'}, function(response) {
		console.log('response: ', response);

		document.querySelector('.league-week-list').innerHTML = response.league_weeks_list;
	});
}

function play_next_week () {
	api_get({target: 'weeks', week_id: number_of_week}, function(response) {
		console.log('response: ', response);

		document.querySelector('.league-week-list').innerHTML += response.league_weeks_item;

		number_of_week++;
	});
}








