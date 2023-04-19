<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Page $page
 */
?>
<div class="row">
    <div class="col">
        <legend>View - <?= h($page->label) ?></legend>
        <?= $this->Html->link(__('<i class="fas fa-edit"></i> Edit Page'), [
            'action' => 'edit', $page->id,
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
                <h4><?= h($page->label.' ('.$page->controller.')') ?></h4>
                <hr>
                <table class="table table-hover table-sm">
                    <tr>
                        <th scope="row"><?= __('Menu') ?></th>
                        <td><?= $page->has('menu') ? $this->Html->link($page->menu->label, ['controller' => 'Menus', 'action' => 'view', $page->menu->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Label') ?></th>
                        <td><?= h($page->label) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Icon') ?></th>
                        <td><?= h($page->icon) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Plugin') ?></th>
                        <td><?= h($page->_plugin) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Prefix') ?></th>
                        <td><?= h($page->prefix) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Controller') ?></th>
                        <td><?= h($page->controller) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Controller Action') ?></th>
                        <td><?= h($page->controller_action) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($page->id) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Sort Order') ?></th>
                        <td><?= $this->Number->format($page->sort_order) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Literal') ?></th>
                        <td><?= $this->element('yes_no_icon', ['boolean' => $page->literal]) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Active') ?></th>
                        <td><?= $this->element('yes_no_icon', ['boolean' => $page->active]) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
