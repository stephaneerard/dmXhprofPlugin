<div style="width: 50%;">
<table>
	<thead>
	<?php ob_start()?>
		<tr>
			<td>id</td>
			<td>time</td>
			<td>namespace</td>
			<td>env</td>
			<td></td>
		</tr>
<?php $head = ob_get_flush()?>
	</thead>
	<tfoot>
	<?php echo $head;?>
	</tfoot>
	<tbody>
	<?php foreach($runs as $run):?>
		<tr>
			<td><?php echo $run['id']?></td>
			<td><?php echo $run['time']?></td>
			<td><?php echo $run['namespace']?></td>
			<td><?php echo $run['env']?></td>
			<td><?php echo $run['link']?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
</div>