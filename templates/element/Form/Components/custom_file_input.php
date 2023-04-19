<?php

if (!isset($inputText)) {
	$inputText = 'Choose a file';
}

if (!isset($accept)) {
	$accept = '';
} else {
	$accept = 'accept="'.$accept.'"';
}

if (isset($onChange)) {
	$change = 'onchange="'.$onChange.'"';
} else {
	$change = '';
}
?>

<div class="form-group row">
	<div class="col-sm-4">
		<?= $label ?>
	</div>
	<div class="col-sm-8">
		<div class="input-group mb-3">
			<input type="file" class="form-control" id="<?= $id ?>" <?= $accept ?> name="<?= $id ?>" <?= $change ?>>
			<label class="input-group-text" for="<?= $id ?>"><?= $inputText ?></label>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('.custom-file-input').on('change',function(){
	    //get the file name
        var fileName = $(this).val().replace('C:\\fakepath\\', " ");
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
	})
</script>