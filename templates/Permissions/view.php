<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Permission $permission
 */

$this->Html->css('datatables/dataTables.bootstrap4.min.css');
?>

<div class="row">
    <div class="col">
        <legend>View - <?= h('') ?></legend>
        <?= $this->Html->link(__('Edit Permission'), ['action' => 'edit', $permission->id]) ?>
        <hr>
    </div>
</div>



<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <h4><?= h('') ?></h4>
                <hr>
                <table class="table table-hover table-sm">
                    <tr>
                        <th scope="row"><?= __('Role') ?></th>
                        <td><?= $permission->has('role') ? $this->Html->link($permission->role->id, ['controller' => 'Roles', 'action' => 'view', $permission->role->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Aco') ?></th>
                        <td><?= $permission->has('aco') ? $this->Html->link($permission->aco->id, ['controller' => 'Acos', 'action' => 'view', $permission->aco->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($permission->id) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Allowed') ?></th>
                        <td><?= $permission->allowed ? __('Yes') : __('No'); ?></td>
                    </tr>
                </table>




            </div>
        </div>
    </div>
</div>
