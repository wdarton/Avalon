<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aco $aco
 */

$this->Html->css('datatables/dataTables.bootstrap4.min.css');
?>

<div class="row">
    <div class="col">
        <legend>View - <?= h('') ?></legend>
        <?= $this->Html->link(__('Edit Aco'), ['action' => 'edit', $aco->id]) ?>
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
                        <th scope="row"><?= __('Parent Aco') ?></th>
                        <td><?= $aco->has('parent_aco') ? $this->Html->link($aco->parent_aco->id, ['controller' => 'Acos', 'action' => 'view', $aco->parent_aco->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Alias') ?></th>
                        <td><?= h($aco->alias) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($aco->id) ?></td>
                    </tr>
                </table>




                <hr>
                <div class="related">
                    <h4><?= __('Related Acos') ?></h4>
                    <?php if (!empty($aco->child_acos)): ?>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Parent Id') ?></th>
                        <th scope="col"><?= __('Alias') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($aco->child_acos as $childAcos): ?>
                    <tr>
                        <td><?= h($childAcos->id) ?></td>
                        <td><?= h($childAcos->parent_id) ?></td>
                        <td><?= h($childAcos->alias) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'Acos', 'action' => 'view', $childAcos->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'Acos', 'action' => 'edit', $childAcos->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Acos', 'action' => 'delete', $childAcos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childAcos->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
                <hr>
                <div class="related">
                    <h4><?= __('Related Permissions') ?></h4>
                    <?php if (!empty($aco->permissions)): ?>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Role Id') ?></th>
                        <th scope="col"><?= __('Aco Id') ?></th>
                        <th scope="col"><?= __('Allowed') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($aco->permissions as $permissions): ?>
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
            </div>
        </div>
    </div>
</div>
