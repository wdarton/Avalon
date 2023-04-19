<p>500 most recent actions</p>
<table class="table table-striped table-hover table-sm" id="actions-table">
    <thead>
        <tr>
            <th></th>
            <th scope="col"><?= __('Created') ?></th>
            <th scope="col"><?= __('Controller') ?></th>
            <th scope="col"><?= __('Controller Action') ?></th>
            <th scope="col"><?= __('Entity Id') ?></th>
            <th scope="col"><?= __('Entity Display Field') ?></th>
            <th scope="col"><?= __('File Location') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($userActions as $userAction): ?>
            <?php // Only show the expand option if there is data to expand! ?>
            <?php if (!is_null($userAction->dirty_fields) && !empty($userAction->dirty_fields)) : ?>
                <tr data-child-value="<?= htmlentities($userAction->dirty_fields) ?>">
                    <td class="details-control"><i class="far fa-plus-square text-primary"></i></td>
            <?php else: ?>
                <tr>
                    <td></td>
            <?php endif; ?>

            <td><?= $this->Element('Time/user_time', [
                'time' => $userAction->created,
                'format' => 'yyyy-MM-dd, HH:mm:ss zzz'
            ]) ?></td>
            <td><?= h($userAction->controller) ?></td>
            <td><?= h($userAction->controller_action) ?></td>
            <td><?= h($userAction->entity_id) ?></td>
            <td><?= h($userAction->entity_display_field) ?></td>
            <td><?= h($userAction->file_location) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

 <?= $this->Element('Datatables/datatable_child_row', [
    'tableId' => 'actions-table',
    'sort' => [
            'column' => 1,
            'direction' => 'DESC',
        ]
    ]) ?>
