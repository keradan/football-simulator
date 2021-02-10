<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
	<link rel="stylesheet" href="public/styles.css">
	<link rel="shortcut icon" href="#">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<title>Football simulator</title>
</head>
<body>
	<section class="section">
		<div class="container">
			<h1 class="title">
				Football simulator
			</h1>
			<p class="subtitle">
				League Table
			</p>

			<table class="table league-table">
				<thead>
				</thead>
				<tbody>
				</tbody>
			</table>
			
			<div class="columns">
				<div class="column">
					<button class="button">Play All</button>
				</div>
				<div class="column">
					<button class="button">Next Week</button>
				</div>
			</div>

			<div class="box">
				<p class="title">Match results</p>
				<div class="league-week-list">
				</div>
			</div>

			<div class="columns">
				<div class="column">
					<button class="button is-danger">Reset League</button>
				</div>
			</div>
		</div>
	</section>
	<script src="public/scripts.js"></script>
</body>
</html>