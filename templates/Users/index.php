<?= $this->Html->css('datatables/dataTables.bootstrap4.min.css') ?>

<div class="row">
    <div class="col">
        <legend>Users</legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <table class="table table-striped table-hover table-sm" id="users-index">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('Full Name') ?></th>
                            <th scope="col"><?= __('Username') ?></th>
                            <th scope="col"><?= __('User Role') ?></th>
                            <th scope="col"><?= __('Login Count') ?></th>
                            <th scope="col"><?= __('Last Logon') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $this->Html->link(__($user->full_name), ['action' => 'view', $user->id]) ?></td>
                            <td><?= $this->Html->link(__($user->username), ['action' => 'view', $user->id]) ?></td>
                            <td><?= h($user->role->label) ?></td>
                            <td><?= h($user->login_count) ?></td>
                            <td><?= $this->Element('Time/user_time', [
                                    'time' => $user->last_logon,
                                ]) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('
                                        <i class="fas fa-sync-alt"></i>
                                        <i class="fas fa-key"></i>
                                    '), [
                                    'action' => 'admin-reset-password',
                                    $user->id
                                ], [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'escape' => false,
                                    'title' => 'Reset Password',
                                ]) ?>
                                <?= $this->Html->link(__('<i class="fas fa-eye"></i>'), [
                                    'action' => 'view', $user->id
                                ], [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'escape' => false,
                                    'title' => 'View',

                                ]) ?>
                                <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), [
                                    'action' => 'edit', $user->id
                                ], [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'escape' => false,
                                    'title' => 'Edit',
                                ]) ?>
                                <?= $this->Form->postLink(__('<i class="fas fa-trash-alt"></i>'), [
                                    'action' => 'delete',
                                    $user->id
                                ], [
                                    'onClick' => "openDeleteModal(".$user->id.",'avalon/".$params["controller"]."','full_name')",
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'escape' => false,
                                    'title' => 'Delete',
                                ]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script('datatables/jquery.dataTables.min.js') ?>
<?= $this->Html->script('datatables/dataTables.bootstrap4.min.js') ?>

<?= $this->Element('Datatables/datatable', [
    'tableId' => 'users-index',
    ]) ?>