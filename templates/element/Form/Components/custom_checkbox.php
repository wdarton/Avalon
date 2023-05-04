<?php

// Usage example
// echo $this->element('Avalon.Form/Components/custom_checkbox', [
// 	'name' => 'recipient_residential',
// 	'label' => 'Residential Address',
// 	'state' => '',
// 	'formType' => 'horiz',
// ]);


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

<?php if ($formType == strtolower('horiz')): ?>
<div class="row mb-3">
	<label class="form-check-label col-sm-4" for="<?= $idName ?>">
		<?= $label ?>
	</label>
	<div class="col-sm-8">
		<div class="form-check">
			<input class="form-check-input  <?= $customClass ?>" type="checkbox" id="<?= $idName ?>" name="<?= $name ?>" value="1" <?= $checked ?>>
		</div>
	</div>
</div>
<?php else: ?>
<div class="form-check">
	<input class="form-check-input  <?= $customClass ?>" type="checkbox" id="<?= $idName ?>" name="<?= $name ?>" value="1" <?= $checked ?>>
	<label class="form-check-label" for="<?= $idName ?>">
		<?= $label ?>
	</label>
</div>

<?php endif; ?>
