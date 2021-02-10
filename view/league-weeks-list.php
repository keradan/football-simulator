<?php foreach ($league_weeks as $week): ?>
	<hr>
	<p class="subtitle">#<?= $week->id ?> Week Match Results</p>
	<table class="table is-striped week-matches" data-week-id="<?= $week->id ?>">
		<tbody>
			<?php foreach ($week->matches as $match_id => $match): ?>
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
<?php endforeach; ?>