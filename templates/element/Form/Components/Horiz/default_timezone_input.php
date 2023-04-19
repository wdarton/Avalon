<?php
echo $this->Html->script('Avalon.select2.min.js',['block' => 'css']);
echo $this->Html->css('Avalon.select2.min.css',['block' => 'css']);
echo $this->Html->css('Avalon.select2-bootstrap.css',['block' => 'css']);

$timezoneArray = [];
$tzIdents = timezone_identifiers_list();
$dt = new DateTime('now');

foreach($tzIdents as $zone)
{
    $thisTz = new DateTimeZone($zone);
    $dt->setTimezone($thisTz);
    $offset = $dt->format('P');
    $timezoneArray[$zone] = $zone . " (UTC/GMT {$offset})";
}

echo $this->Form->control('user_timezone', [
    'type' => 'select',
    'options' => $timezoneArray,
]);

?>
<script type="text/javascript">
	$('#user-timezone').select2({
	    theme: "bootstrap",
		width: '100%',
        <?php if (isset($modal)): ?>
            dropdownParent: $('#<?= $modal ?>'),
        <?php endif; ?>
	});
</script>
