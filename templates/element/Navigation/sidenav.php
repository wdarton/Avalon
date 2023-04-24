<style type="text/css">
.sidebar a {
    color: var(--bs-dark-text);
}

.sidebar button {
    color: var(--bs-dark-text);

}
</style>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark-subtle sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav nav-pills nav-fill flex-column">
            <li class="nav-item">
                <span class="d-inline-flex">Overview</span>
            </li>
        </ul>
        <hr>
        <ul class="list-unstyled ps-0">
            <?php foreach($navMenus as $navMenu) : ?>

                <?php
                // if (!$this->Auth->isAuthorized($authUser,$navMenu)) {
                //     continue;
                // }

                // Figure out which menu we are in and highlight it in the navigation
                $active = false;
                if (strtolower($this->request->getParam('controller') ?? '') == strtolower($navMenu->controller ?? '')) {
                    // If there is a prefix set, check for that match
                    if (($this->request->getParam('prefix'))) {
                        if (strtolower($this->request->getParam('prefix') ?? '') == strtolower($navMenu->prefix ?? '')) {
                            $active = 'border-4 border-start border-primary ps-1';
                        }
                    } elseif (isset($page)) {
                        // We must be in the pages controller
                        if (strtolower($page ?? '') == strtolower($navMenu->controller_action ?? '')) {
                            $active = 'border-4 border-start border-primary ps-1';
                        }
                    } elseif (!$navMenu->prefix) {
                        $active = 'border-4 border-start border-primary ps-1';
                    }

                } elseif (isset($page)) {
                    // Perhaps we are in a specific page?
                    if (strtolower($page ?? '') == strtolower($navMenu->controller_action) ?? '') {
                            $active = 'border-4 border-start border-primary ps-1';
                        }
                }

                // Prep for an icon if there is one
                $icon = '';

                if ($navMenu->icon) {
                    $icon = '<i class="'.$navMenu->icon.' fa-fw"></i> ';
                }
                ?>
                <li class="">
                    <?php if (!empty($navMenu->pages)) : ?>
                        <?php // There are child pages for this menu ?>
                        <button class="btn btn-toggle p-2 d-inline-flex align-items-center w-100 border-0 rounded-0 collapsed" data-bs-toggle="collapse" data-bs-target="#<?= $this->Text->slug($navMenu->label) ?>-collapse" aria-expanded="<?= $active ? 'true' : 'false' ?>">
                            <span class="<?= $active ?>"><?= $icon.$navMenu->label ?></span>
                        </button>
                        <div class="collapse <?= $active ? 'show' : '' ?>" id="<?= $this->Text->slug($navMenu->label) ?>-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <?php foreach ($navMenu->pages as $navPage) : ?>
                                    <?php if ($navPage->literal): ?>
                                        <?= $this->Html->link($navPage->label,
                                                ($navPage->prefix ? $navPage->prefix : '').'/'.$navPage->controller.'/'.$navPage->controller_action,
                                                ['class' => ' d-inline-flex text-decoration-none w-100', 'escape' => false,]
                                            ); ?>
                                    <?php else: ?>
                                        <li>
                                            <?= $this->Html->link($navPage->label, [
                                                'prefix' => $navPage->prefix ? $navPage->prefix : false,
                                                'controller' => $navPage->controller,
                                                'action' => $navPage->controller_action,
                                            ],
                                            [
                                                'class' => ' d-inline-flex text-decoration-none w-100',
                                                'escape' => false,
                                            ]) ?>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php else : ?>
                        <?php // There are no child pages for this menu ?>
                        <?php if ($navMenu->literal): ?>
                            <?= $this->Html->link("<span class='{$active}'>{$icon}{$navMenu->label}</span>",
                                    ($navMenu->prefix ? $navMenu->prefix : '').($navMenu->controller ? '/'.$navMenu->controller : '').'/'.$navMenu->controller_action,
                                    ['class' => 'btn btn-menu p-2 d-inline-flex align-items-center w-100 border-0 rounded-0', 'escape' => false,]
                                ); ?>
                        <?php else: ?>
                                <?= $this->Html->link("<span class='{$active}'>{$icon}{$navMenu->label}</span>", [
                                    'prefix' => $navMenu->prefix ? $navMenu->prefix : false,
                                    'controller' => $navMenu->controller,
                                    'action' => $navMenu->controller_action,
                                ],
                                [
                                    'class' => 'btn btn-menu p-2 d-inline-flex align-items-center w-100 border-0 rounded-0',
                                    'escape' => false,
                                ]) ?>
                        <?php endif; ?>
                    <?php endif ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <hr>
        <ul class="nav nav-pills nav-fill flex-column">
            <li class="nav-item">
                <span class="d-inline-flex">System Tools</span>
            </li>
        </ul>
        <ul class="list-unstyled ps-0">
            <?php foreach($adminNavMenus as $adminMenu) : ?>

                <?php
                // if (!$this->Auth->isAuthorized($authUser,$adminMenu)) {
                //     continue;
                // }

                // Figure out which menu we are in and highlight it in the navigation
                $active = false;
                if (strtolower($this->request->getParam('controller') ?? '') == strtolower($adminMenu->controller ?? '')) {
                    // If there is a prefix set, check for that match
                    if (($this->request->getParam('prefix'))) {
                        if (strtolower($this->request->getParam('prefix') ?? '') == strtolower($adminMenu->prefix ?? '')) {
                            $active = 'border-4 border-start border-primary ps-1';
                        }
                    } elseif (isset($page)) {
                        // We must be in the pages controller
                        if (strtolower($page ?? '') == strtolower($adminMenu->controller_action ?? '')) {
                            $active = 'border-4 border-start border-primary ps-1';
                        }
                    } elseif (!$adminMenu->prefix) {
                        $active = 'border-4 border-start border-primary ps-1';
                    }

                } elseif (strtolower($this->request->getParam('plugin') ?? '') == strtolower($adminMenu->controller ?? '')) {
                    // This must be a plugin
                    $active = 'border-4 border-start border-primary ps-1';

                }

                // Prep for an icon if there is one
                $icon = '';

                if ($adminMenu->icon) {
                    $icon = '<i class="'.$adminMenu->icon.' fa-fw"></i> ';
                }
                ?>

                <li class="">
                    <?php if (!empty($adminMenu->pages)) : ?>
                        <button class="btn btn-toggle p-2 d-inline-flex align-items-center w-100 border-0 rounded-0 collapsed" data-bs-toggle="collapse" data-bs-target="#<?= $adminMenu->label ?>-collapse" aria-expanded="<?= $active ? 'true' : 'false' ?>">
                            <span class="<?= $active ?>"><?= $icon.$adminMenu->label ?></span>
                        </button>
                        <div class="collapse <?= $active ? 'show' : '' ?>" id="<?= $adminMenu->label ?>-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <?php foreach ($adminMenu->pages as $adminPage) : ?>
                                    <?php if ($adminPage->literal): ?>
                                        <?= $this->Html->link($adminPage->label,
                                                ($adminPage->prefix ? $adminPage->prefix : '').'/'.$adminPage->controller.'/'.$adminPage->controller_action,
                                                ['class' => ' d-inline-flex text-decoration-none w-100', 'escape' => false,]
                                            ); ?>
                                    <?php else: ?>
                                        <li>
                                            <?= $this->Html->link($adminPage->label, [
                                                'prefix' => $adminPage->prefix ? $adminPage->prefix : false,
                                                'controller' => $adminPage->controller,
                                                'action' => $adminPage->controller_action,
                                            ],
                                            [
                                                'class' => ' d-inline-flex text-decoration-none w-100',
                                            ]) ?>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <?php // There are no child pages for this menu ?>
                        <?php if ($adminMenu->literal): ?>
                            <?= $this->Html->link("<span class='{$active}'>{$adminMenu->label}</span>",
                                    ($adminMenu->prefix ? $adminMenu->prefix : '').($adminMenu->controller ? '/'.$adminMenu->controller : '').'/'.$adminMenu->controller_action,
                                    ['class' => 'btn btn-menu p-2 d-inline-flex align-items-center w-100 border-0 rounded-0', 'escape' => false,]
                                ); ?>
                        <?php else: ?>
                                <?= $this->Html->link("<span class='{$active}'>{$adminMenu->label}</span>", [
                                    'prefix' => $adminMenu->prefix ? $adminMenu->prefix : false,
                                    'controller' => $adminMenu->controller,
                                    'action' => $adminMenu->controller_action,
                                ],
                                [
                                    'class' => 'btn btn-menu p-2 d-inline-flex align-items-center w-100 border-0 rounded-0',
                                    'escape' => false,
                                ]) ?>
                        <?php endif; ?>
                    <?php endif ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <hr>
        <ul class="nav flex-column mb-2">
            <li>
                
            </li>
        </ul>
    </div>
</nav>