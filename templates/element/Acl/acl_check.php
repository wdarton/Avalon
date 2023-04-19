<?php
// Make sure that we were passed an entity that we can check against!!
if (!isset($entity)) {
	return false;
} else {
	$aro = [
	    'model' => 'Users',
	    'foreign_key' => $authUser->id,
	];
	$aco = $entity->controller.'/'.$entity->controller_action;

	// Custom check for ACL menu option
	if ($entity->controller === 'AclManager') {
	    $aco = 'Acl/'.$entity->controller_action;
	}

	$allowed = $acl->check($aro, $aco);

	return $allowed;
}

?>