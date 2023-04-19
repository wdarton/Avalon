<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Permission[]|\Cake\Collection\CollectionInterface $permissions
 */
?>

<?= $this->Html->css('datatables/dataTables.bootstrap4.min.css') ?>


<div class="row">
    <div class="col">
        <legend>Permissions</legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <table class="table table-striped table-hover table-sm" id="permissions-index">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('id') ?></th>
                            <th scope="col"><?= __('role_id') ?></th>
                            <th scope="col"><?= __('aco_id') ?></th>
                            <th scope="col"><?= __('allowed') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($permissions as $permission): ?>
                        <tr>
                            <td><?= $this->Number->format($permission->id) ?></td>
                            <td><?= $permission->has('role') ? $this->Html->link($permission->role->id, ['controller' => 'Roles', 'action' => 'view', $permission->role->id]) : '' ?></td>
                            <td><?= $permission->has('aco') ? $this->Html->link($permission->aco->id, ['controller' => 'Acos', 'action' => 'view', $permission->aco->id]) : '' ?></td>
                            <td><?= h($permission->allowed) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $permission->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $permission->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $permission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $permission->id)]) ?>
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
    'tableId' => 'permissions-index',
    ]) ?>

