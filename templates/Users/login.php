<?php
$this->element('Form/Templates/vert-full-width');
?>

<link href="https://fonts.googleapis.com/css?family=Iceland" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Expletus+Sans&display=swap" rel="stylesheet">

<div class="row justify-content-sm-center align-self-center">
	<div class="col-sm-4">
		<h1 class="text-center avalon">AVALON</h1>
		<h5 class="text-center"><em>Avalon CakePHP Plugin</em></h5>

		<?= $this->Form->create() ?>
		    <?php
	        	echo $this->Form->control('username', [
	        		'autofocus',
	        	]);
	        	echo $this->Form->control('password');
	            // echo $this->Form->control('user_code', [
	            // 	'placeholder' => 'User Code',
	            // 	'type' => 'password',
	            // 	'autofocus' => 'true',
	            // ]);

	            // Check for redirect
	            if (isset($params['?']['redirect'])) {
	            	echo $this->Form->hidden('redirect', [
	            		'value' => $params['?']['redirect'],
	            	]);
	            }
		    ?>
			<div class="text-center">
			    <?= $this->Form->button(__('Submit')) ?>
			</div>
		<?= $this->Form->end() ?>
	</div>
</div>