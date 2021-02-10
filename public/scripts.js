let api_url = window.location.href + 'api.php';

console.log('api_url: ', api_url);

$.ajax({
	url: api_url,
	data: {
		foo: 'bar'
	},
	dataType: 'json',
	method: 'post',
	success: function(response){
		console.log(response);
	},
	error: function(error){
		console.log(error);
	},
});