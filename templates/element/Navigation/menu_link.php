<?php
    if (!isset($class)) {
        $class = 'nav-link';
    }
?>

<!-- Is this a literal menu item? -->
<?php if ($navMenu->literal): ?>
    <?= $this->Html->link($navMenu->label,
            ($navMenu->prefix ? $navMenu->prefix : '').'/'.$navMenu->controller.'/'.$navMenu->controller_action,
            ['class' => $class]
        ); ?>
<?php else: ?>
<!-- Standard CakePHP menu -->
    <?= $this->Html->link($navMenu->label, [
                'prefix' => $navMenu->prefix ? $navMenu->prefix : false,
                'controller' => $navMenu->controller,
                'action' => $navMenu->controller_action,
                'plugin' => $navMenu->plugin,
            ],
            ['class' => $class]
        ); ?>
<?php endif; ?>