<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
	<link as="style" rel="stylesheet" href="public/styles.css">
	<link rel="shortcut icon" href="#">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<title>Football simulator</title>
</head>
<body>
	<section class="section">
		<div class="container">
			<h1 class="title">
				Hello World
			</h1>
			<p class="subtitle">
				My first website with <strong>Bulma</strong>!
			</p>

			<?php
				$table_head = [
					'POS' => 'Position',
					'Team' => 'Team',
					'PTS' => 'Points',
					'PLD' => 'Played',
					'W' => 'Won',
					'D' => 'Drawn',
					'L' => 'Lost',
					'GD' => 'Goal difference',
					'PDC' => 'Predictions of Championship',
				];
				$teams = [
					(object)[
						'title' => 'Leicester City',
						'PTS' => '81',
						'PLD' => '15',
						'W' => '23',
						'D' => '12',
						'L' => '3',
						'GD' => '+25',
						'PDC' => '56%',
					],
					(object)[
						'title' => 'Arsenal',
						'PTS' => '70',
						'PLD' => '15',
						'W' => '20',
						'D' => '11',
						'L' => '6',
						'GD' => '+12',
						'PDC' => '43%',
					],
					(object)[
						'title' => 'Tottenham Hotspur',
						'PTS' => '64',
						'PLD' => '14',
						'W' => '18',
						'D' => '8',
						'L' => '6',
						'GD' => '+5',
						'PDC' => '23%',
					],
					(object)[
						'title' => 'Manchester City',
						'PTS' => '62',
						'PLD' => '14',
						'W' => '17',
						'D' => '9',
						'L' => '8',
						'GD' => '-3',
						'PDC' => '5%',
					],
				];
			?>

			<table class="table">
				<thead>
					<tr>
						<?php foreach ($table_head as $head_item_title => $head_item_description): ?>
							<th><abbr title="<?= $head_item_description ?>"><?= $head_item_title ?></abbr></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($teams as $pos => $team): ?>
						<tr>
							<th data-field="POS"><?= $pos + 1 ?></th>
							<th data-field="title"><?= $team->title ?></th>
							<th data-field="PTS"><?= $team->PTS ?></th>
							<th data-field="PLD"><?= $team->PLD ?></th>
							<th data-field="W"><?= $team->W ?></th>
							<th data-field="D"><?= $team->D ?></th>
							<th data-field="L"><?= $team->L ?></th>
							<th data-field="GD"><?= $team->GD ?></th>
							<th data-field="PDC"><?= $team->PDC ?></th>
						</tr>
					<?php endforeach; ?>
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
				<table class="table is-striped">
					<tbody>
						<?php foreach ($matches as $match): ?>
							<tr>
								<th style="border-bottom: none;">
									<?= $match->owner->name ?>
								</th>
								<th style="border-bottom: none;">
									<input class="input" type="text" style="width: 33px; height: 33px;" value="<?= $match->owner->goals ?>">
								</th>
								<th style="border-bottom: none;"> - </th>
								<th style="border-bottom: none;">
									<input class="input" type="text" style="width: 33px; height: 33px;" value="<?= $match->guest->goals ?>">
								</th>
								<th style="border-bottom: none;">
									<?= $match->guest->name ?>
								</th>
								<th style="border-bottom: none;">
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