<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserRole $userRole
 */

$this->Html->css('datatables/dataTables.bootstrap4.min.css');
?>

<div class="row">
    <div class="col">
        <legend>View - <?= h('') ?></legend>
        <?= $this->Html->link(__('Edit User Role'), ['action' => 'edit', $userRole->id]) ?>
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
                        <th scope="row"><?= __('User') ?></th>
                        <td><?= $userRole->has('user') ? $this->Html->link($userRole->user->id, ['controller' => 'Users', 'action' => 'view', $userRole->user->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Role') ?></th>
                        <td><?= $userRole->has('role') ? $this->Html->link($userRole->role->id, ['controller' => 'Roles', 'action' => 'view', $userRole->role->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($userRole->id) ?></td>
                    </tr>
                </table>




            </div>
        </div>
    </div>
</div>
