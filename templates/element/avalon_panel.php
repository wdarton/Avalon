<h3>Request Information</h3>
<table>
	<thead>
		<th></th>
		<th></th>
	</thead>
	<tbody>
		<?php if (!is_null($params['prefix'])) : ?>
				<tr>
					<td><strong>Prefix</strong></td>
					<td><?= $params['prefix'] ?></td>
				</tr>
		<?php endif; ?>
		<?php if (!is_null($params['plugin'])) : ?>
			<tr>
				<td><strong>Plugin</strong></td>
				<td><?= $params['plugin'] ?></td>
			</tr>
		<?php endif; ?>
		<?php if (!is_null($params['controller'])) : ?>
			<tr>
				<td><strong>Controller</strong></td>
				<td><?= $params['controller'] ?></td>
			</tr>
		<?php endif; ?>
		<?php if (!is_null($params['action'])) : ?>
			<tr>
				<td><strong>Action</strong></td>
				<td><?= $params['action'] ?></td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>
<br>
<h3>Current User Information</h3>
<table>
	<thead>
		<th></th>
		<th></th>
	</thead>
	<tbody>
		<tr>
			<td><strong>Full Name</strong></td>
			<td><?= is_null($identity) ? 'No identity' : $identity->full_name ?></td>
		</tr>
	</tbody>
</table>
<hr>
<h3>Access Check</h3>
<?php
$controller = $params['controller'];
$action = $params['action'];
$prefix = $params['prefix'];
$plugin = $params['plugin'];

if (!is_null($identity)) {
	// Check for a plugin first
	if (!is_null($plugin)) {
	    // Check for a prefix 
	    if (!is_null($prefix)) {
	    	echo 'Plugin w/ prefix: ';
	        echo  (bool) $identity['permissions'][$plugin]['children'][$prefix]['children'][$controller]['allowed'] ? 'Allowed' : 'Denied';
	    } else {
	    	echo 'Plugin: ';
	        echo (bool) $identity['permissions'][$plugin]['children'][$controller]['children'][$action]['allowed'] ? 'Allowed' : 'Denied';
	    }
	} else {
	    if (!is_null($prefix)) {
	    	echo 'Prefix: ';
	        echo (bool) $identity['permissions'][$prefix]['children'][$controller]['children'][$action]['allowed'] ? 'Allowed' : 'Denied';
	    } else {
	    	echo 'Controller: ';
	        echo (bool) $identity['permissions'][$controller]['children'][$action]['allowed'] ? 'Allowed' : 'Denied';
	    }
	}
} else {
	echo 'No identity';
}
?>

<!-- <pre><?= print_r($identity, true) ?></pre> -->
