<?php
$idName = str_replace('_', '-', $name);
if (!isset($label)) {
	$label = ucwords(str_replace('_', ' ', $name));
}
switch ($state) {
	case true:
		$checked = 'checked';
		break;
	default:
		$checked = '';
		break;
}
if (!isset($customClass)) {
	$customClass = '';
}
?>

<div class="form-check">
	<input class="form-check-input  <?= $customClass ?>" type="checkbox" id="<?= $idName ?>" name="<?= $name ?>" value="1" <?= $checked ?>>
	<label class="form-check-label" for="<?= $idName ?>">
		<?= $label ?>
	</label>
</div>