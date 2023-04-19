<p>500 most recent logins</p>
<table class="table table-striped table-hover table-sm" id="login-log-table">
    <thead>
        <tr>
            <th scope="col"><?= __('Created') ?></th>
            <th scope="col"><?= __('IPv4 Address') ?></th>
            <th scope="col"><?= __('Success') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($userLogins as $userLogin): ?>
        <tr>
            <td><?= $this->Element('Time/user_time', [
                'time' => $userLogin->created,
                'format' => 'yyyy-MM-dd, HH:mm:ss zzz'
            ]) ?></td>
            <td><?= h($userLogin->ipv4_address) ?></td>
            <td><?= $this->element('yes_no_icon', ['boolean' => $userLogin->success]) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->Element('Datatables/datatable', [
    'tableId' => 'login-log-table',
    'sort' => [
            'column' => 0,
            'direction' => 'DESC',
        ]
    ]) ?>