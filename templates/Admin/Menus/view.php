<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Menu $menu
 */
?>
<div class="row">
    <div class="col">
        <legend>View - <?= h($menu->label) ?></legend>
        <?= $this->Html->link(__('<i class="fas fa-edit"></i> Edit Menu'), [
            'action' => 'edit', $menu->id,
        ], [
            'class' => 'btn btn-sm btn-secondary',
            'escape' => false,
        ]) ?>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <h4><?= h($menu->label) ?></h4>
                <hr>
                <table class="table table-hover table-sm">
                    <tr>
                        <th scope="row"><?= __('Label') ?></th>
                        <td><?= h($menu->label) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Icon') ?></th>
                        <td><?= h($menu->icon) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Plugin') ?></th>
                        <td><?= h($menu->_plugin) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Prefix') ?></th>
                        <td><?= h($menu->prefix) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Controller') ?></th>
                        <td><?= h($menu->controller) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Controller Action') ?></th>
                        <td><?= h($menu->controller_action) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($menu->id) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Sort Order') ?></th>
                        <td><?= $this->Number->format($menu->sort_order) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Active') ?></th>
                        <td><?= $this->element('yes_no_icon', ['boolean' => $menu->active]) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Literal') ?></th>
                        <td><?= $this->element('yes_no_icon', ['boolean' => $menu->literal]) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Visible') ?></th>
                        <td><?= $this->element('yes_no_icon', ['boolean' => $menu->visible]) ?></td>
                    </tr>
                </table>
                <hr>
                <div class="related">
                    <h4><?= __('Related Pages') ?></h4>
                    <?php if (!empty($menu->pages)): ?>
                            <table class="table table-striped table-hover table-sm">
                                <tr>
                                    <th scope="col"><?= __('Sort Order') ?></th>
                                    <th scope="col"><?= __('Label') ?></th>
                                    <th scope="col"><?= __('Icon') ?></th>
                                    <th scope="col"><?= __('Prefix') ?></th>
                                    <th scope="col"><?= __('Controller') ?></th>
                                    <th scope="col"><?= __('Controller Action') ?></th>
                                    <th scope="col"><?= __('Active') ?></th>
                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                                </tr>
                                <?php foreach ($menu->pages as $pages): ?>
                                <tr>
                                    <td><?= h($pages->sort_order) ?></td>
                                    <td><?= $this->Html->link($pages->label, ['controller' => 'Pages', 'action' => 'view', $pages->id]) ?></td>
                                    <td><?= h($pages->icon) ?></td>
                                    <td><?= h($pages->prefix) ?></td>
                                    <td><?= h($pages->controller) ?></td>
                                    <td><?= h($pages->controller_action) ?></td>
                                    <td><?= h($pages->active) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Pages', 'action' => 'view', $pages->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Pages', 'action' => 'edit', $pages->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Pages', 'action' => 'delete', $pages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pages->id)]) ?>
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
