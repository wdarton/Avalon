<?php

$icon = $this->Html->image('Avalon.acl/inherit_32.png');
// $icon = $this->Html->image('Avalon.acl/allow_inherited_32.png');
// $icon = $this->Html->image('Avalon.acl/deny_inherited_32.png');

if (!isset($value)) {
	$value = -1;
} else {

	if ($value == -1) {
		// inherit
		if (!is_null($parentAcoId)) {
			$tmpValue = $permissions[$parentAcoId]['allowed'];

			// Check the if there is a grandparent just in case
			// If there is we should use the allowed value from there instead
			if (!is_null($permissions[$parentAcoId]['parent_aco_id']) &&
				$tmpValue == -1) {


				// Check if there is a great-grandparent
				// If there is we should use the allowed value from there instead
				$grandparentAcoId = $permissions[$parentAcoId]['parent_aco_id'];
				$tmpValue = $permissions[$grandparentAcoId]['allowed'];

				if (!is_null($permissions[$grandparentAcoId]['parent_aco_id']) &&
				$tmpValue == -1) {
					$greatGrandparentAcoId = $permissions[$grandparentAcoId]['parent_aco_id'];
					// $tmpValue = 'ggp'.$permissions[$greatGrandparentAcoId]['allowed'];
					$tmpValue = $permissions[$greatGrandparentAcoId]['allowed'];
				} else {
					// $tmpValue = 'gp'.$permissions[$grandparentAcoId]['allowed'];
					$tmpValue = $permissions[$grandparentAcoId]['allowed'];
				}
			}

		} else {
			$tmpValue = 0; // Assume false
		}

		switch ($tmpValue) {
			case 1:
				$icon = $this->Html->image('Avalon.acl/allow_inherited_32.png');
				break;
			case 0:
			case -1:
				$icon = $this->Html->image('Avalon.acl/deny_inherited_32.png');
				break;
		}

	} else {
		// explicit
		switch ($value) {
			case 1:
				$icon = $this->Html->image('Avalon.acl/allow_32.png');
				break;
			case 0:
				$icon = $this->Html->image('Avalon.acl/deny_32.png');
				break;
		}
	}

}

echo '<td>';
// echo (isset($tmpValue)) ? 't'.$tmpValue : 'v'.$value;
// echo ' ';
echo $icon.'</td>';
echo '<td>';
echo $this->Form->select(
	'aco-'.$acoId,
	[
		1  => 'Allow',
		-1 => 'Inherit',
		0  => 'Deny',
	],
	[
		'value' => $value,
	]
);
echo '</td>';