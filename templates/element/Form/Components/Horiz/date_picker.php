<?php
// Requires an existing form control to attach to

// Also include in calling file
echo $this->Html->script('Avalon.bootstrap-datepicker');
echo $this->Html->css('Avalon.bootstrap-datepicker5');

$idName = str_replace('_', '-', $name);
if (!isset($orientation)) {
	$orientation = 'bottom';
}
?>

<script type="text/javascript">
    $('#<?= $idName ?>').datepicker({
        format: 'mm/dd/yyyy',
        autoclose: true,
        clearBtn: true,
        orientation: '<?= $orientation ?>',
        todayHighlight: true,
    });
</script>