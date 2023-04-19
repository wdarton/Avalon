<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role[]|\Cake\Collection\CollectionInterface $roles
 */
?>

<?= $this->Html->css('datatables/dataTables.bootstrap4.min.css') ?>


<div class="row">
    <div class="col">
        <legend>Roles</legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <table class="table table-striped table-hover table-sm" id="roles-index">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('id') ?></th>
                            <th scope="col"><?= __('label') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roles as $role): ?>
                        <tr>
                            <td><?= $this->Number->format($role->id) ?></td>
                            <td><?= h($role->label) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('<i class="fas fa-eye"></i>'), [
                                    'action' => 'view', $role->id
                                ], [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'escape' => false,
                                    'title' => 'View',

                                ]) ?>
                                <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), [
                                    'action' => 'edit', $role->id
                                ], [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'escape' => false,
                                    'title' => 'Edit',
                                ]) ?>
                                <?= $this->Form->postLink(__('<i class="fas fa-trash-alt"></i>'), [
                                    'action' => 'delete',
                                    $role->id
                                ], [
                                    'onClick' => "openDeleteModal(".$role->id.",'avalon/".$params["controller"]."','full_name')",
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'escape' => false,
                                    'title' => 'Delete',
                                ]) ?>
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
    'tableId' => 'roles-index',
    ]) ?>

