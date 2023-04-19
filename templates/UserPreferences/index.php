<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $userPreferences
 */
?>

<?= $this->Html->css('Avalon.datatables/dataTables.bootstrap4.min.css') ?>


<div class="row">
    <div class="col">
        <legend>User Preferences</legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <table class="table table-striped table-hover table-sm" id="userPreferences-index">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('id') ?></th>
                            <th scope="col"><?= __('user_id') ?></th>
                            <th scope="col"><?= __('user_timezone') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($userPreferences as $userPreference): ?>
                        <tr>
                            <td><?= $this->Number->format($userPreference->id) ?></td>
                            <td><?= $this->Number->format($userPreference->user_id) ?></td>
                            <td><?= h($userPreference->user_timezone) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $userPreference->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userPreference->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $userPreference->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userPreference->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="paginator">
                    <ul class="pagination justify-content-end">
                        <?= $this->Paginator->first('<<') ?>
                        <?= $this->Paginator->prev(__('Previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('Next')) ?>
                        <?= $this->Paginator->last('>>') ?>
                    </ul>
                    <p class="float-right"><?= $this->Paginator->counter(__('Page  of , showing  record(s) out of  total')) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script('Avalon.datatables/jquery.dataTables.min.js') ?>
<?= $this->Html->script('Avalon.datatables/dataTables.bootstrap4.min.js') ?>

<?= $this->Element('Avalon.Datatables/datatable', [
    'tableId' => 'userPreferences-index',
    ]) ?>

