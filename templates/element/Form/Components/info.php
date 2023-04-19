<?php
$idName = str_replace('_', '-', $name);

if (!isset($placement)) {
	$placement = 'right';
}
?>

<script type="text/javascript">
	$(function () {
	  var infoGroup = "";

		infoGroup += '<div class="input-group-append">';
		infoGroup += '    <span class="input-group-text">';
		infoGroup += '        <i class="fas fa-question-circle text-info info-icon" data-trigger="hover" data-toggle="popover" data-html="true" data-placement="<?= $placement ?>" data-content="<?= $content ?>"></i>';
		infoGroup += '    </span>';
		infoGroup += '</div>';

		$(infoGroup).insertAfter("#<?= $idName ?>");
		$("#<?= $idName ?>").parent().addClass('input-group input-group-sm');
		$("#<?= $idName ?>").parent().removeClass('col-sm-8');
		$("#<?= $idName ?>").parent().wrap('<div class="col-sm-8"></div>');

		$('[data-toggle="popover"]').popover();
	})
</script>