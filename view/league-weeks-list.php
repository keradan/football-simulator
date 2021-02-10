<?php foreach ($league_weeks as $week): ?>
	<p class="subtitle" style="text-align: center;">#<?= $week->id ?> Week Match Results</p>
	<table class="table is-striped week-matches" data-week-id="<?= $week->id ?>" style="width: 100%; max-width: 600px; margin: 0 auto;">
		<tbody>
			<?php foreach ($week->matches as $match_id => $match): ?>
				<tr data-match-num="<?= $match_id ?>">
					<th style="text-align: right; min-width: 230px;">
						<?= $match->owner->name ?>
					</th>
					<th style="width: 30px">
						<input class="input" type="text" value="<?= $match->owner->goals ?>" data-old-value="<?= $match->owner->goals ?>">
						<button class="icon noselect">✓</button>
					</th>
					<th style="width: 10px"> - </th>
					<th style="width: 30px">
						<input class="input" type="text" value="<?= $match->guest->goals ?>" data-old-value="<?= $match->guest->goals ?>">
						<button class="icon noselect">✓</button>
					</th>
					<th style="min-width: 230px;">
						<?= $match->guest->name ?>
					</th>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<hr>
<?php endforeach; ?>