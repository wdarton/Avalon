<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aco $aco
 */

$this->element('Form/Templates/horiz-sm');
?>
<div class="row">
    <div class="col">
        <legend>Add Aco</legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-6">
                    <?= $this->Form->create($aco) ?>
                    	<?php
	                        echo $this->Form->control('id');
	                        echo $this->Form->control('parent_id');
	                        echo $this->Form->control('alias');
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