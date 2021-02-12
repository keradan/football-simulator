<?php foreach ($teams as $pos => $team_data): ?>
	<?php $team_data->POS = $pos + 1 ?>
	<tr>
		<?php foreach ($columns as $column): ?>
			<th data-field="<?= $column->title ?>"><?= $team_data->{$column->title} ?></th>
		<?php endforeach; ?>		
	</tr>
<?php endforeach; ?>