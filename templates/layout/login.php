<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Configure;

// $this->layout = 'login';

$cakeDescription = $appDescription;
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php if (Configure::read('debug')): ?>
            DEV |
        <?php endif; ?>
        <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->meta('charset', 'utf-8') ?>
    <?= $this->Html->meta('theme-color', '#405B85') ?>

    <?= $this->Html->css('Avalon.bootstrap5.3/custom') ?>
    <?= $this->Html->css('https://use.fontawesome.com/releases/v5.15.0/css/all.css') ?>

    <?= $this->Html->script('https://code.jquery.com/jquery-3.3.1.min.js') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body id="main-body" class="bg-body-secondary">
<div class="row g-0">

<div class="container-fluid">
    <div class="row">
        <div class="col-6 offset-3 py-3">
            <?php if (Configure::read('debug')): ?>
                <div class="alert alert-dark text-center">
                    <i class="fas fa-cogs"></i>  Debug is enabled.
                </div>

            <?php endif; ?>
            <?= $this->Flash->render() ?>
        </div>
    </div>
    <div class="row flex-nowrap">
        <div class="col">
            <?= $this->fetch('content') ?>
        </div>
    </div>
</div>

<div>
</div>
    
    


<?= $this->Html->script('https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js') ?>
<?= $this->Html->script('Avalon.bootstrap5.3/bootstrap') ?>
<?= $this->fetch('script') ?>

</body>
</html>
