<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Page[]|\Cake\Collection\CollectionInterface $pages
 */
?>
<?= $this->Html->css('datatables/dataTables.bootstrap4.min.css') ?>

<div class="row">
    <div class="col">
        <legend>Pages</legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <table class="table table-striped table-hover table-sm" id="pages-index">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('Label') ?></th>
                            <th scope="col"><?= __('Menu') ?></th>
                            <th scope="col"><?= __('Plugin') ?></th>
                            <th scope="col"><?= __('Prefix') ?></th>
                            <th scope="col"><?= __('Controller') ?></th>
                            <th scope="col"><?= __('Controller Action') ?></th>
                            <th scope="col"><?= __('Sort Order') ?></th>
                            <th scope="col"><?= __('Literal') ?></th>
                            <th scope="col"><?= __('Active') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pages as $page): ?>
                        <tr>
                            <td><?= $this->Html->link(h($page->label), ['action' => 'view', $page->id]) ?></td>
                            <td><?= $page->has('menu') ? $this->Html->link($page->menu->label, ['controller' => 'Menus', 'action' => 'view', $page->menu->id]) : '' ?></td>
                            <td><?= h($page->_plugin) ?></td>
                            <td><?= h($page->prefix) ?></td>
                            <td><?= h($page->controller) ?></td>
                            <td><?= h($page->controller_action) ?></td>
                            <td><?= $this->Number->format($page->sort_order) ?></td>
                            <td><?= $this->element('yes_no_icon', ['boolean' => $page->literal]) ?></td>
                            <td><?= $this->element('yes_no_icon', ['boolean' => $page->active]) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('<i class="fas fa-eye"></i>'), [
                                    'action' => 'view', $page->id
                                ], [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'escape' => false,
                                    'title' => 'View',

                                ]) ?>
                                <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), [
                                    'action' => 'edit', $page->id
                                ], [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'escape' => false,
                                    'title' => 'Edit',
                                ]) ?>
                                <?= $this->Form->postLink(__('<i class="fas fa-trash-alt"></i>'), [
                                    'action' => 'delete',
                                    $page->id
                                ], [
                                    'onClick' => "openDeleteModal(".$page->id.",'admin/".$params["controller"]."','full_name')",
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
    'tableId' => 'pages-index',
    'sort' => [
        'column' => 1,
        'direction' => 'ASC',
    ]
]) ?>