<?php
use Cake\Utility\Inflector;

// Usage:
/**
 * echo $this->Element('Form/Components/Horiz/multiple_picker', [
        'formOptions' => $courses,
        'id' => 'current_course',
        'empty' => true,
        'emptyPlaceholder' => 'Select a course',
        'entity' => $person,
    ]);
 */

echo $this->Html->script('Avalon.select2.min.js',['block' => 'css']);
echo $this->Html->css('Avalon.select2.min.css',['block' => 'css']);
echo $this->Html->css('Avalon.select2-bootstrap.css',['block' => 'css']);


$elementId = $id;

if (!isset($multiple)) {
	$multiple = '';
}

if ($multiple == true) {
	$multiple = 'multiple';
	$elementId = Inflector::pluralize($id);
}

$elementLabel = Inflector::humanize($elementId);

// remove _id for the label if it is there
if (strpos($elementId, '_id') !== false) {
	$elementLabel = Inflector::humanize(str_replace('_id', '', $elementId));
}

$emptyJsSettings = '';

if (isset($empty)) {
	$emptyJsSettings = "
		placeholder: '{$emptyPlaceholder}',
		allowClear: true
	";
} else {
	$empty = false;
}

if ($empty) {
	echo $this->Form->control($elementId,[
		'options' => $formOptions,
		'label' => $elementLabel,
		'multiple' => $multiple,
		'empty' => true,
		'value' => '',
	]);

} else {
	echo $this->Form->control($elementId,[
		'options' => $formOptions,
		'label' => $elementLabel,
		'multiple' => $multiple,
	]);
}

// Replace underscores with dashes to make javascript happy
$jsId = str_replace('_', '-', $elementId);
?>
<script type="text/javascript">
	$(function() {

		$('#<?= $jsId ?>').select2({
		    theme: "bootstrap",
		    width: '100%',
		    <?php if (isset($modal)): ?>
		        dropdownParent: $('#<?= $modal ?>'),
		    <?php endif; ?>
		    <?= $emptyJsSettings ?>
		});

		<?php if (isset($entity)): ?>
			$('#<?= $jsId ?>').val('<?= $entity->$id ?>');
			$('#<?= $jsId ?>').trigger('change');
		<?php endif; ?>

		<?php if (isset($default)): ?>
			$('#<?= $jsId ?>').val('<?= $default ?>');
			$('#<?= $jsId ?>').trigger('change');
		<?php endif; ?>
	});

</script>