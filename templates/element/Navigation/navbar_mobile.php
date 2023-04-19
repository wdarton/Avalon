<ul class="navbar-nav">
    <?php foreach ($navMenus as $navMenu): ?>
        <?php
            $active = '';
            if (strtolower($this->request->params['controller']) == strtolower($navMenu->controller)) {

                // If there is a prefix set, check for that match
                if (isset($this->request->params['prefix'])) {
                    if (strtolower($this->request->params['prefix']) == strtolower($navMenu->prefix)) {
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

            } elseif (strtolower($this->request->params['plugin']) == strtolower($navMenu->controller)) {
                // This must be a plugin
                $active = 'active';

            }
        ?>

        <!-- If there are pages for the menu, build out a dropdown -->
        <?php if (!empty($navMenu->pages)) : ?>

            <li class="nav-item dropdown <?= $active ?>">
                <?= $this->Html->link($navMenu->label, '#',
                    [
                        'class' => 'nav-link dropdown-toggle text-white',
                        'id' => $navMenu->label . '-id',
                        'role' => 'button',
                        'data-toggle' => 'dropdown',
                    ]) ?>

                <div class="dropdown-menu" aria-labelledby="nav<?= $navMenu->label ?>">
                    <?= $this->element('Navigation/menu_link', [
                        'class' => 'dropdown-item',
                        'navMenu' => $navMenu,
                    ]); ?>

                    <div class="dropdown-divider"></div>

                    <?php foreach ($navMenu->pages as $navPage) : ?>

                        <?php
                            // Ensure the user can access this resource!
                            // $allowed = $this->Acl->aclCheck($navPage);
                            $allowed = true;

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
                        'class' => 'nav-link text-white',
                        'navMenu' => $navMenu,
                    ]); ?>
            </li>

        <?php endif; ?>
    <?php endforeach; ?>
    <?php if ($authUser): ?>
        <li class="nav-item">
            <?= $this->Html->link('Logout', [
                'controller' => 'users',
                'action' => 'logout',
            ], [
                'class' => 'nav-link text-white',
            ]); ?>
        </li>
    <?php endif; ?>
</ul>