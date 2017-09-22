<table>
	<tr>
		<th><?=$game->game_time?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?=$game->away_name?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$game->home_name?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$game->stadinum?></th>
	</tr> 
</table>
<br/>
<br/>
<table>
	<tr>
		<th width="300px;"><?=$game->away_name?></th>
		<th width="300px;"><?=$game->home_name?></th>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<th>백넘버</th>
					<th>이름</th>
					<th>포지션</th>
				</tr>
<?php foreach($away_line as $entry){ ?>
				<tr>
					<td><?=$entry->back_num?></td>
					<td><?=$entry->name?></td>
					<td><?=$entry->position?></td>
				</tr>
<?php } ?>
			</table>
		</td>
		<td>
			<table>
				<tr>
					<th>백넘버</th>
					<th>이름</th>
					<th>포지션</th>
				</tr>
<?php foreach($home_line as $entry){ ?>
				<tr>
					<td><?=$entry->back_num?></td>
					<td><?=$entry->name?></td>
					<td><?=$entry->position?></td>
				</tr>
<?php } ?>
			</table>
		</td>
	</tr>
</table>