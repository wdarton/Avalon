<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */

$this->Html->css('datatables/dataTables.bootstrap4.min.css');
?>

<div class="row">
    <div class="col">
        <legend>View - <?= h('') ?></legend>
        <?= $this->Html->link(__('Edit Role'), ['action' => 'edit', $role->id]) ?>
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
                        <th scope="row"><?= __('Label') ?></th>
                        <td><?= h($role->label) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($role->id) ?></td>
                    </tr>
                </table>




                <hr>
                <div class="related">
                    <h4><?= __('Related Permissions') ?></h4>
                    <?php if (!empty($role->permissions)): ?>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Role Id') ?></th>
                        <th scope="col"><?= __('Aco Id') ?></th>
                        <th scope="col"><?= __('Allowed') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($role->permissions as $permissions): ?>
                    <tr>
                        <td><?= h($permissions->id) ?></td>
                        <td><?= h($permissions->role_id) ?></td>
                        <td><?= h($permissions->aco_id) ?></td>
                        <td><?= h($permissions->allowed) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'Permissions', 'action' => 'view', $permissions->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'Permissions', 'action' => 'edit', $permissions->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Permissions', 'action' => 'delete', $permissions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $permissions->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
                <hr>
                <div class="related">
                    <h4><?= __('Related User Roles') ?></h4>
                    <?php if (!empty($role->user_roles)): ?>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('User Id') ?></th>
                        <th scope="col"><?= __('Role Id') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($role->user_roles as $userRoles): ?>
                    <tr>
                        <td><?= h($userRoles->id) ?></td>
                        <td><?= h($userRoles->user_id) ?></td>
                        <td><?= h($userRoles->role_id) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'UserRoles', 'action' => 'view', $userRoles->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'UserRoles', 'action' => 'edit', $userRoles->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserRoles', 'action' => 'delete', $userRoles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userRoles->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
            </div>
        </div>
    </div>
</div>
