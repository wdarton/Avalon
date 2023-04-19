<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Menu[]|\Cake\Collection\CollectionInterface $menus
 */
?>
<?= $this->Html->css('datatables/dataTables.bootstrap4.min.css') ?>

<div class="row">
    <div class="col">
        <legend>Menus</legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <table class="table table-striped table-hover table-sm" id="menus-index">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('Sort Order') ?></th>
                            <th scope="col"><?= __('Label') ?></th>
                            <th scope="col"><?= __('Plugin') ?></th>
                            <th scope="col"><?= __('Prefix') ?></th>
                            <th scope="col"><?= __('Controller') ?></th>
                            <th scope="col"><?= __('Controller Action') ?></th>
                            <th scope="col"><?= __('Active') ?></th>
                            <th scope="col"><?= __('Literal') ?></th>
                            <th scope="col"><?= __('Visible') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menus as $menu): ?>
                        <tr>
                            <td><?= $this->Number->format($menu->sort_order) ?></td>
                            <td><?= $this->Html->link(h($menu->label), ['action' => 'view', $menu->id]) ?></td>
                            <td><?= h($menu->_plugin) ?></td>
                            <td><?= h($menu->prefix) ?></td>
                            <td><?= h($menu->controller) ?></td>
                            <td><?= h($menu->controller_action) ?></td>
                            <td><?= $this->element('yes_no_icon', ['boolean' => $menu->active]) ?></td>
                            <td><?= $this->element('yes_no_icon', ['boolean' => $menu->literal]) ?></td>
                            <td><?= $this->element('yes_no_icon', ['boolean' => $menu->visible]) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('<i class="fas fa-eye"></i>'), [
                                    'action' => 'view', $menu->id
                                ], [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'escape' => false,
                                    'title' => 'View',

                                ]) ?>
                                <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), [
                                    'action' => 'edit', $menu->id
                                ], [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'escape' => false,
                                    'title' => 'Edit',
                                ]) ?>
                                <?= $this->Form->postLink(__('<i class="fas fa-trash-alt"></i>'), [
                                    'action' => 'delete',
                                    $menu->id
                                ], [
                                    'onClick' => "openDeleteModal(".$menu->id.",'admin/".$params["controller"]."','full_name')",
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
    'tableId' => 'menus-index',
    'sort' => [
        'column' => 0,
        'direction' => 'ASC',
    ]
]) ?>