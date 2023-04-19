<?php
	$yes = '<i class="fas fa-check text-success"></i> Yes';
	$no = '<i class="fas fa-times text-danger"></i> No';
?>
<?= $boolean ? __($yes) : __($no); ?>