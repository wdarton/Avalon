<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SystemSetting[]|\Cake\Collection\CollectionInterface $systemSettings
 */
?>

<?= $this->Html->css('datatables/dataTables.bootstrap4.min.css') ?>


<div class="row">
    <div class="col">
        <legend>System Settings</legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover table-sm" id="systemSettings-index">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('id') ?></th>
                            <th scope="col"><?= __('system_timezone') ?></th>
                            <th scope="col"><?= __('current_course_id') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($systemSettings as $systemSetting): ?>
                        <tr>
                            <td><?= $this->Number->format($systemSetting->id) ?></td>
                            <td><?= h($systemSetting->system_timezone) ?></td>
                            <td><?= h($systemSetting->current_course_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $systemSetting->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $systemSetting->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $systemSetting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $systemSetting->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script('datatables/jquery.dataTables.min.js') ?>
<?= $this->Html->script('datatables/dataTables.bootstrap4.min.js') ?>

<?= $this->Element('Datatables/datatable', [
    'tableId' => 'systemSettings-index',
    ]) ?>

