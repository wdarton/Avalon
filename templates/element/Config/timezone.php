<?php
?>
<div class="row">
	<div class="col">
		<strong>Time</strong>
		<hr>
		<table class="table table-hover table-sm col">
			<tbody>
				<tr>
					<th>System Timezone</th>
					<td><?= $systemSettings->system_timezone ?></td>
				</tr>
			</tbody>
		</table>
		<button class="btn btn-primary btn-sm" onclick="editEntity(<?= $systemSettings->id ?>, '/config/system-settings', 'edit-timezone')">Change Timezone</button>
	</div>
</div>