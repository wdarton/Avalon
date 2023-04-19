<?php
if (!isset($placement)) {
	$placement = 'right';
}

if (!isset($float)) {
	$float = '';
} else {
	switch ($float) {
		case 'left':
			$float = 'float-left';
			break;
		case 'right':
			$float = 'float-right';
			break;
		default:
			$float = '';
			break;
	}
}
?>

<i class="fas fa-question-circle text-info info-icon <?= $float ?>" data-trigger="hover" data-toggle="popover" data-html="true" data-placement="<?= $placement ?>" data-content="<?= $content ?>"></i>

<script type="text/javascript">
	$(function () {
	  $('[data-toggle="popover"]').popover();
	})
</script>