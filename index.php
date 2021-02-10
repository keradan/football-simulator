<?php



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
	<link as="style" rel="stylesheet" href="public/styles.css">
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
					],
					(object)[
						'title' => 'Arsenal',
						'PTS' => '70',
						'PLD' => '15',
						'W' => '20',
						'D' => '11',
						'L' => '6',
						'GD' => '+12',
					],
					(object)[
						'title' => 'Tottenham Hotspur',
						'PTS' => '64',
						'PLD' => '14',
						'W' => '18',
						'D' => '8',
						'L' => '6',
						'GD' => '+5',
					],
					(object)[
						'title' => 'Manchester City',
						'PTS' => '62',
						'PLD' => '14',
						'W' => '17',
						'D' => '9',
						'L' => '8',
						'GD' => '-3',
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
					<?php $pos = 0; ?>
					<?php foreach ($teams as $team): ?>
						<?php $pos++; ?>
						<tr>
							<th><?= $pos ?></th>
							<th><?= $team->title ?></th>
							<th><?= $team->PTS ?></th>
							<th><?= $team->PLD ?></th>
							<th><?= $team->W ?></th>
							<th><?= $team->D ?></th>
							<th><?= $team->L ?></th>
							<th><?= $team->GD ?></th>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</section>
	<script src="public/scripts.js"></script>
</body>
</html>