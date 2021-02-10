<tr class="is-selected">
	<?php foreach ($columns as $column): ?>
		<th><abbr title="<?= $column->description ?>"><?= $column->title ?></abbr></th>
	<?php endforeach; ?>
</tr>