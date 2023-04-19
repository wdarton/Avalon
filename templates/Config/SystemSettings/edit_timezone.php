<?php
$this->element('Form/Templates/horiz-sm');
?>
<?= $this->Form->create($systemSetting, ['id' => 'modal-form']) ?>
	<?= $this->Form->control('id'); ?>
	<?= $this->Element('Form/Components/Horiz/default_timezone_input') ?>
<?= $this->Form->end() ?>
<script type="text/javascript">
	$('#mySelect2').select2({
	        dropdownParent: $('#myModal')
	    });
</script>