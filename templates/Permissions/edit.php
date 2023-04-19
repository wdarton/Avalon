<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Permission $permission
 */

 $this->element('Form/Templates/horiz-sm');
?>
<div class="row">
    <div class="col">
        <legend>Edit Permission - </legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <div class="col-sm-6">
                    <?= $this->Form->create($permission) ?>
                    	<?php
	                        echo $this->Form->control('id');
	                        echo $this->Form->control('role_id');
	                        echo $this->Form->control('aco_id');
	                        echo $this->element('Form/Components/Horiz/switch', [
                                'name' => 'allowed',
                                'entity' => $permission,
                            ]);
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
