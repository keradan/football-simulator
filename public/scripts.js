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

// 1 достать данные таблицы api_get({target:'league_table'})
function refresh_league_table () {
	let table = document.querySelector('table.league-table');
	table.classList.toggle('loading', true);

	api_get({target:'league_table'}, function(response){
		console.log('response.league_table: ', response.league_table);
		
		let columns_order = [];
		let table_head_columns = [];
		response.league_table.table_head.forEach(function(column) {
			columns_order.push(column.title);
			table_head_columns.push(`<th><abbr title="${column.description}">${column.title}</abbr></th>`);
		});
		table.querySelector('thead').innerHTML = `<tr>${table_head_columns.join('')}</tr>`

		let table_body_rows = [];
		response.league_table.teams.forEach(function(team) {
			let table_body_row_columns = []
			columns_order.forEach(function(column_name) {
				table_body_row_columns.push(`<th data-field="${column_name}">${team[column_name]}</th>`);
			});
			table_body_rows.push(`<tr>${table_body_row_columns.join('')}</tr>`);
		});
		table.querySelector('tbody').innerHTML = table_body_rows.join('');

		table.classList.toggle('loading', false);
	})
}








