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
			
			
			<?php
				$matches = [
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
				];
			?>

			<div class="box">
				<p class="title">Match results</p>
				<hr>
				<p class="subtitle">#5 Week Match Results</p>
				<table class="table is-striped week-matches" data-week-id="<?= 5 ?>">
					<tbody>
						<?php foreach ($matches as $match_id => $match): ?>
							<tr data-match-num="<?= $match_id ?>">
								<th>
									<?= $match->owner->name ?>
								</th>
								<th>
									<input class="input" type="text" value="<?= $match->owner->goals ?>">
								</th>
								<th> - </th>
								<th>
									<input class="input" type="text" value="<?= $match->guest->goals ?>">
								</th>
								<th>
									<?= $match->guest->name ?>
								</th>
								<th>
									<button class="button is-success is-light">Save</button>
								</th>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<script src="public/scripts.js"></script>
</body>
</html>