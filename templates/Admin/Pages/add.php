<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Page $page
 */
$this->element('Form/Templates/horiz-sm');
?>
<div class="row">
    <div class="col">
        <legend>Add Page</legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body row">
                <div class="col-sm-6">
                    <?= $this->Form->create($page) ?>
                    <legend><?= __('Add Page') ?></legend>
                    <?php
                        echo $this->Form->control('menu_id', ['options' => $menus]);
                        echo $this->Form->control('label');
                        echo $this->Form->control('icon');
                        echo $this->Form->control('_plugin');
                        echo $this->Form->control('prefix');
                        echo $this->Form->control('controller');
                        echo $this->Form->control('controller_action');
                        echo $this->Form->control('sort_order');
                        echo $this->element('Form/Components/Horiz/switch', [
                            'name' => 'literal',
                        ]);
                        echo $this->element('Form/Components/Horiz/switch', [
                            'name' => 'active',
                        ]);
                    ?>
                    <div class="text-center">
                        <?= $this->Form->button(__('Submit')) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
                <div class="col-sm-6">
                    <h4>Common Icons</h4>
                    <hr>
                    <?= $this->Html->link('Font Awesome', 'https://fontawesome.com/icons?d=gallery&m=free',
                        ['target' => '_blank']
                    ) ?>
                    <br>
                    <br>
                    <ul class="list-unstyled text-primary">
                        <li><i class="fas fa-eye"></i> fas fa-eye</li>
                        <li><i class="fas fa-plus"></i> fas fa-plus</li>
                        <li><i class="fas fa-download"></i> fas fa-download</li>
                        <li><i class="fas fa-upload"></i> fas fa-upload</li>
                        <li><i class="fas fa-envelope"></i> fas fa-envelope</li>
                        <li><i class="fas fa-external-link-alt"></i> fas fa-external-link-alt</li>
                        <li><i class="fas fa-folder"></i> fas fa-folder</li>
                        <li><i class="fas fa-hdd"></i> fas fa-hdd</li>
                        <li><i class="fas fa-pencil-alt"></i> fas fa-pencil-alt</li>
                        <li><i class="fas fa-server"></i> fas fa-server</li>
                        <li><i class="fas fa-sitemap"></i> fas fa-sitemap</li>
                        <li><i class="fas fa-sliders-h"></i> fas fa-sliders-h</li>
                        <li><i class="fas fa-user"></i> fas fa-user</li>
                        <li><i class="fas fa-cog"></i> fas fa-cog</li>
                        <li><i class="fas fa-cogs"></i> fas fa-cogs</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>