<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $userPreference
 */

$this->element('Avalon.Form/Templates/horiz-sm');
?>
<div class="row">
    <div class="col">
        <legend>Add User Preference</legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <div class="col-sm-6">
                    <?= $this->Form->create($userPreference) ?>
                    	<?php
	                        echo $this->Form->control('id');
	                        echo $this->Form->control('user_id');
	                        echo $this->Form->control('user_timezone');
                        ?>
                    <div class="text-center">
                        <?= $this->Form->button(__('Submit')) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>