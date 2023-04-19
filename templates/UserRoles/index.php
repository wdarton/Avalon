<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserRole[]|\Cake\Collection\CollectionInterface $userRoles
 */
?>

<?= $this->Html->css('datatables/dataTables.bootstrap4.min.css') ?>


<div class="row">
    <div class="col">
        <legend>User Roles</legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <table class="table table-striped table-hover table-sm" id="userRoles-index">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('id') ?></th>
                            <th scope="col"><?= __('user_id') ?></th>
                            <th scope="col"><?= __('role_id') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($userRoles as $userRole): ?>
                        <tr>
                            <td><?= $this->Number->format($userRole->id) ?></td>
                            <td><?= $userRole->has('user') ? $this->Html->link($userRole->user->id, ['controller' => 'Users', 'action' => 'view', $userRole->user->id]) : '' ?></td>
                            <td><?= $userRole->has('role') ? $this->Html->link($userRole->role->id, ['controller' => 'Roles', 'action' => 'view', $userRole->role->id]) : '' ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $userRole->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userRole->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $userRole->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userRole->id)]) ?>
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
    'tableId' => 'userRoles-index',
    ]) ?>

