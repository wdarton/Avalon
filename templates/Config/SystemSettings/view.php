<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SystemSetting $systemSetting
 */

$this->Html->css('datatables/dataTables.bootstrap4.min.css');
?>

<div class="row">
    <div class="col">
        <legend>View - <?= h('') ?></legend>
        <?= $this->Html->link(__('Edit System Setting'), ['action' => 'edit', $systemSetting->id]) ?>
        <hr>
    </div>
</div>



<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4><?= h('') ?></h4>
                <hr>
                <table class="table table-hover table-sm">
                    <tr>
                        <th scope="row"><?= __('System Timezone') ?></th>
                        <td><?= h($systemSetting->system_timezone) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Current Course Id') ?></th>
                        <td><?= h($systemSetting->current_course_id) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($systemSetting->id) ?></td>
                    </tr>
                </table>




            </div>
        </div>
    </div>
</div>
