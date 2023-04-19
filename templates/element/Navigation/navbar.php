<ul class="navbar-nav">
    <?php foreach ($navMenus as $navMenu): ?>
        <?php
            if (!$this->Auth->isAuthorized($authUser,$navMenu)) {
                continue;
            }

            $active = '';
            if (strtolower($this->request->getParam('controller')) == strtolower($navMenu->controller)) {
                // If there is a prefix set, check for that match
                if (($this->request->getParam('prefix'))) {
                    if (strtolower($this->request->getParam('prefix')) == strtolower($navMenu->prefix)) {
                        $active = 'active';
                    }
                } elseif (isset($page)) {
                    // We must be in the pages controller
                    if (strtolower($page) == strtolower($navMenu->controller_action)) {
                            $active = 'active';
                    }
                } elseif (!$navMenu->prefix) {
                    $active = 'active';
                }

            } elseif (strtolower($this->request->getParam('plugin')) == strtolower($navMenu->controller)) {
                // This must be a plugin
                $active = 'active';

            }
        ?>

        <!-- If there are pages for the menu, build out a dropdown -->
        <?php if (!empty($navMenu->pages)) : ?>

            <li class="nav-item dropdown <?= $active ?>">
                <?= $this->Html->link($navMenu->label, [
                        'prefix' => $navMenu->prefix ? $navMenu->prefix : false,
                        'controller' => $navMenu->controller,
                        'action' => $navMenu->controller_action,
                        'plugin' => $navMenu->plugin,
                    ],
                    [
                        'class' => 'nav-link dropdown-toggle ',
                    ]) ?>

                <div class="dropdown-menu material-strong" aria-labelledby="nav<?= $navMenu->label ?>">
                    <?= $this->element('Navigation/menu_link', [
                        'class' => 'dropdown-item',
                        'navMenu' => $navMenu,
                    ]); ?>

                    <div class="dropdown-divider"></div>

                    <?php foreach ($navMenu->pages as $navPage) : ?>

                        <?php
                            // Ensure the user can access this resource!
                            $allowed = $this->Auth->isAuthorized($authUser,$navPage);

                            if (!$allowed) {
                                continue;
                            }
                        ?>

                        <?php if ($navPage->literal): ?>
                            <?= $this->Html->link($navPage->label,
                                    ($navPage->prefix ? $navPage->prefix : '').'/'.$navPage->controller.'/'.$navPage->controller_action,
                                    ['class' => 'dropdown-item', 'escape' => false,]
                                ); ?>
                        <?php else: ?>
                            <?= $this->Html->link($navPage->label, [
                                'prefix' => $navPage->prefix ? $navPage->prefix : false,
                                'controller' => $navPage->controller,
                                'action' => $navPage->controller_action,
                                'plugin' => $navPage->plugin,
                            ],
                                ['class' => 'dropdown-item', 'escape' => false,]
                            ); ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </li>

        <?php else: ?>

            <li class="nav-item <?= $active ?>">
                <?= $this->element('Navigation/menu_link', [
                        'class' => 'nav-link',
                        'navMenu' => $navMenu,
                    ]); ?>
            </li>

        <?php endif; ?>
    <?php endforeach; ?>
</ul>