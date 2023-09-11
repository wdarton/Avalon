<hr>
<div class="text-center">
    <?php if(isset($identity)): ?>
        You are currently logged in as:
        <br>
        <strong><?= $currentUser->full_name ?></strong>
        <br>
        <?= $this->Html->link('Reset Password', [
                'prefix' => 'avalon',
                'plugin' => null,
                'controller' => 'Users',
                'action' => 'reset-password'
            ],
            ['class' => 'btn btn-link btn-sm']
        ) ?>
        <br>
        <br>
        <?= $this->Html->link('Logout', [
                'prefix' => 'avalon',
                'plugin' => null,
                'controller' => 'Users',
                'action' => 'logout'
            ],
            ['class' => 'btn btn-light']
        ) ?>
    <?php else: ?>
        You are not currently logged in
        <br>
        <br>
        <?= $this->Html->link('Login', [
                'prefix' => 'avalon',
                'plugin' => null,
                'controller' => 'Users',
                'action' => 'login',
            ],
            ['class' => 'btn btn-light']
        ) ?>
    <?php endif; ?>
</div>
<hr>