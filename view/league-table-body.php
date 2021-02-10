<?php foreach ($teams as $team_columns): ?>
	<tr>
		<?php foreach ($team_columns as $teams_column_title => $teams_column_value): ?>
			<th data-field="<?= $teams_column_title ?>"><?= $teams_column_value ?></th>
		<?php endforeach; ?>		
	</tr>
<?php endforeach; ?>