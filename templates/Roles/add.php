<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */

$this->element('Form/Templates/horiz-sm');
?>
<div class="row">
    <div class="col">
        <legend>Add Role</legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <div class="col-sm-6">
                    <?= $this->Form->create($role) ?>
                    	<?php
	                        echo $this->Form->control('id');
	                        echo $this->Form->control('label');
                            // echo $this->Element('Acl/permissions_add');
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