<?php
$idName = str_replace('_', '-', $name);
if (!isset($label)) {
	$label = ucwords(str_replace('_', ' ', $name));
}
if (isset($checked)) {
	if ($checked) {
		$checked = 'checked';
	} else {
		$checked = '';
	}
} else {
	$checked = '';
}

if (isset($entity) && $entity->$name) {
	$checked = 'checked';
}

// This excludes this field from the form security component
// $this->Form->unlockField($name);

?>
<div class="mb-3 row">
    <label for="<?= $idName ?>" class="col-sm-4"><?= $label ?></label>
    <div class="col-sm-8 switch">
            <input type="checkbox" class="switch" id="<?= $idName ?>" name="<?= $name ?>" <?= $checked ?> value="1">
            <label for="<?= $idName ?>"></label>
    </div>
</div>