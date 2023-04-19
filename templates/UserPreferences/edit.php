<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $userPreference
 */

 $this->element('Avalon.Form/Templates/horiz-sm');
?>
<div class="row">
    <div class="col">
        <legend>Edit User Preferences</legend>
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
	                        echo $this->Form->hidden('user_id');
                            echo $this->Form->hidden('redirect', [
                                'value' => $this->getRequest()->referer(),
                            ]);
	                        echo $this->Element('Form/Components/Horiz/default_timezone_input');
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
