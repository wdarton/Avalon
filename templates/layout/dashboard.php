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

$cakeDescription = 'Avalon';
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
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->meta('charset', 'utf-8') ?>
    <?= $this->Html->meta('theme-color', '#405B85') ?>

    <?= $this->Html->css('Avalon.bootstrap5.3/custom') ?>
    <?= $this->Html->css('Avalon.bootstrap5.3/sidebars') ?>
    <?= $this->Html->css('https://use.fontawesome.com/releases/v5.15.0/css/all.css') ?>


    <?= $this->Html->script('https://code.jquery.com/jquery-3.3.1.min.js') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>

    <style>


</style>
</head>
<body id="main-body" class="bg-body-secondary">

    <nav class="navbar navbar-expand-lg sticky-top bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand text-light">Navbar</a>
                <form class="d-flex text-center" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                </form>
            <ul class="navbar-nav">
                <?= $this->element('Avalon.theme_selector') ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <button class="btn btn-primary dropdown-toggle"><?= $identity->get('fist_name') ?></button>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
                <?= $this->element('Avalon.Navigation\sidenav') ?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="col py-3">
                        <div class="pb-1"></div>
                        <div class="row">
                            <div class="col">
                                <?php if (Configure::read('debug')): ?>
                                    <div class="alert alert-dark text-center">
                                        <i class="fas fa-cogs"></i>  Debug is enabled.
                                    </div>

                                <?php endif; ?>
                                <?= $this->Flash->render() ?>
                            </div>
                        </div>
                        <?= $this->fetch('content') ?>
                        <hr>
                        <footer class="text-center">Footer!</footer>
                    </div>
                </main>
            </div>
        </div>

        <?php
            if ($params['action'] == 'index') {
                echo $this->Element('Avalon.Modal/delete_index');

            }
        ?>
        <?= $this->Html->script('https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js') ?>
        <?= $this->Html->script('Avalon.bootstrap5.3/bootstrap') ?>
        <?= $this->Html->script('Avalon.bootstrap5.3/sidebars') ?>
        <?= $this->fetch('script') ?>

    </body>
    </html>
