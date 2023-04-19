<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SystemSetting $systemSetting
 */

 $this->element('Form/Templates/horiz-sm');
?>
<div class="row">
    <div class="col">
        <legend>Edit System Setting - </legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-6">
                    <?= $this->Form->create($systemSetting) ?>
                    	<?php
	                        echo $this->Form->control('id');
	                        echo $this->Form->control('system_timezone');
	                        echo $this->Form->control('current_course_id');
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
